<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Appointment;
use App\Models\Race;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(){
        $animals = Animal::where('deleted_at', null)->get();
        $services = Service::where('deleted_at', null)->get();
        return view('welcome', compact('animals', 'services'));
    }

    // Nuevo método para guardar la cita
    public function storeAppointment(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Validar reCAPTCHA primero
            $secretKey = '6LcsYCYsAAAAAPT9_ET9HJh3dgOyb5MxODBB0WAZ';
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $request->input('g_recaptcha_response'),
                'remoteip' => $request->ip(),
            ]);
            
            if (!$response->successful() || !$response->json('success') || $response->json('score') < 0.5) {
                return redirect()->back()->withErrors(['recaptcha' => 'Error de validación de reCAPTCHA. Por favor, inténtalo de nuevo.'])->withInput();
            }

            // 2. Validación de los datos del formulario
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|digits:8',
                'email' => 'nullable|email',
                'pet_race' => 'required|exists:races,id',
                'pet_name' => 'required|string|max:255',
                'pet_type' => 'required|exists:animals,id',
                'pet_gender' => 'required|string|in:Macho,Hembra,Desconocido',
                'pet_age' => 'required|string|max:100',
                'appointment_date' => 'required|date|after_or_equal:today',
                'appointment_time' => 'required|date_format:H:i',
                'pet_photo' => 'nullable|image|max:2048',
                'appointment_location' => 'required|string|max:500',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'service' => 'required|exists:services,id',
                'terms' => 'accepted'
            ]);
            

            // Manejo de la subida de archivos (si existe)
            $photoPath = null;
            if ($request->hasFile('pet_photo')) {
                $photoPath = $request->file('pet_photo')->store('appointment', 'public');
            }

            // return $request;
            // Crear y guardar la nueva cita en la base de datos
            Appointment::create([
                'service_id' => $request->service,
                'animal_id' => $request->pet_type,
                'race_id' => $request->pet_race,
                'nameClient' => $request->name,
                'phoneClient' => $request->phone,
                'nameAnimal' => $request->pet_name,
                'gender' => $request->pet_gender,
                'age' => $request->pet_age,
                'date' => $request->appointment_date,
                'time' => $request->appointment_time,
                'file' => $photoPath,
                'observation' => $request->message,
                'latitud' => $request->latitude,
                'longitud' => $request->longitude,
                // Los campos 'status' y 'view' ya tienen valores por defecto en la migración.
            ]);

            // Obtener detalles para la notificación
            $serviceName = Service::find($request->service)->name;
            $animalType = Animal::find($request->pet_type)->name;
            $race = Race::find($request->pet_race)->name ?? 'No especificada';


            // Construir el mensaje detallado para WhatsApp
            $notificationMessage = "🗓️ *¡Nueva Solicitud de Cita!* 🗓️\n\n" .
                "Se ha recibido una nueva solicitud con los siguientes detalles:\n\n" .
                "👤 *Cliente:* {$request->name}\n" .
                "📞 *Teléfono:* {$request->phone}\n\n" .
                "🐾 *Mascota:*\n" .
                "   - *Nombre:* {$request->pet_name}\n" .
                "   - *Tipo:* {$animalType}\n" .
                "   - *Raza:* {$race}\n" .
                "   - *Género:* {$request->pet_gender}\n" .
                "   - *Edad:* {$request->pet_age}\n\n" .
                "🩺 *Servicio Solicitado:*\n" .
                "   - {$serviceName}\n\n" .
                "🗓️ *Fecha y Hora:*\n" .
                "   - {$request->appointment_date} a las {$request->appointment_time}\n\n" .
                "📝 *Detalle de la Cita:*\n" .
                "_{$request->message}_\n\n" .

                "📍 *Ubicación de la Cita:*\n" .
                "   - Ver en mapa: https://www.google.com/maps?q={$request->latitude},{$request->longitude}\n\n" .            "Por favor, revisa el panel de administración para gestionar la cita.";
            
            $notificationMessage .= "\n\n*Contacto Directo:*\n" .
                "Haz clic para contactar al cliente: https://wa.me/591{$request->phone}\n\n" .
                "*Gestionar Cita:*\n" .
                "https://consultorioveterinariocortez.com/admin/appointments";
            $servidor = setting('solucion-digital.servidorWhatsapp');
            $id = setting('solucion-digital.sessionWhatsapp');

            if(setting('redes-sociales.whatsapp') && setting('solucion-digital.servidorWhatsapp') && setting('solucion-digital.sessionWhatsapp'))
            {
                Http::post($servidor.'/send?id='.$id.'&token='.null, [
                        'phone' => '+591'.setting('redes-sociales.whatsapp'),
                        'text' => $notificationMessage,
                    ]);
            }


            DB::commit();
            // Redirigir de vuelta a la página anterior con un mensaje de éxito
            return redirect('/')->with('success', '¡Gracias! Tu solicitud de cita ha sido enviada. Nos pondremos en contacto contigo pronto.'); 
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error al guardar la cita: '.$th->getMessage());
            return redirect()->back()->withErrors('Hubo un error al procesar tu solicitud. Por favor, intenta nuevamente.')->withInput();
        }
        // return redirect('/#cita')->with('success', '¡Gracias! Tu solicitud de cita ha sido enviada. Nos pondremos en contacto contigo pronto.');
    }

    /**
     * Obtiene las razas para una especie de animal y las devuelve como JSON.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRaces(Animal $animal)
    {
        $races = $animal->races()->where('status', 1)->orderBy('name')->get();
        return response()->json($races);
    }
}
