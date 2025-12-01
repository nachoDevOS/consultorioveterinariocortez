<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|digits:8',
            'email' => 'nullable|email',
            'pet_name' => 'required|string|max:255',
            'pet_type' => 'required|exists:animals,id', // Valida que el ID de la especie exista en la tabla 'animals'
            'pet_gender' => 'required|string|in:Macho,Hembra,Desconocido',
            'pet_age' => 'required|string|max:100',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'pet_photo' => 'nullable|image|max:2048', // Opcional, tipo imagen, máximo 2MB
            'appointment_location' => 'required|string|max:500', // Dirección obtenida por geocodificación
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'service' => 'required|exists:services,id', // Validar que el ID del servicio exista
            'message' => 'required|string|max:1000',
            'terms' => 'accepted'
        ]);
      
        // Manejo de la subida de archivos (si existe)
        $photoPath = null;
        if ($request->hasFile('pet_photo')) {
            // En una aplicación real, aquí guardarías el archivo en el sistema de almacenamiento
            // y guardarías la ruta en la base de datos. Lo haremos ahora.
            $photoPath = $request->file('pet_photo')->store('quotes', 'public');
        }

        // return $request;
        // Crear y guardar la nueva cita en la base de datos
        Appointment::create([
            'service_id' => $request->service,
            'animal_id' => $request->pet_type,
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

        // return 1;
        // Redirigir de vuelta a la página anterior con un mensaje de éxito
        return redirect('/#cita')->with('success', '¡Gracias! Tu solicitud de cita ha sido enviada. Nos pondremos en contacto contigo pronto.');
    }
}
