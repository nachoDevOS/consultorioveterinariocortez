<?php

namespace App\Http\Controllers;

use App\Models\Animal;
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
            'pet_gender' => 'required|string|in:macho,hembra,desconocido',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'pet_photo' => 'nullable|image|max:2048', // Opcional, tipo imagen, máximo 2MB
            'appointment_location' => 'required|string|max:500', // Dirección obtenida por geocodificación
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'service' => 'required|string', // Considerar validar si este servicio existe en una tabla de servicios
            'message' => 'required|string',
            'terms' => 'accepted'
        ]);

        // Manejo de la subida de archivos (si existe)
        $photoPath = null;
        if ($request->hasFile('pet_photo')) {
            // En una aplicación real, aquí guardarías el archivo en el sistema de almacenamiento
            // y guardarías la ruta en la base de datos.
            // Ejemplo: $photoPath = $request->file('pet_photo')->store('pet_photos', 'public');
            // Por ahora, solo registramos el nombre original del archivo.
            Log::info('Foto de mascota subida:', ['filename' => $request->file('pet_photo')->getClientOriginalName()]);
            $photoPath = 'uploads/pet_photos/' . $request->file('pet_photo')->getClientOriginalName(); // Ruta de ejemplo
        }

        // Guardamos la información en el log de Laravel
        Log::info('Nueva solicitud de cita:', array_merge($validatedData, ['pet_photo_path' => $photoPath]));
        // Redirigir de vuelta a la página anterior con un mensaje de éxito
        return back()->with('success', '¡Gracias! Tu solicitud de cita ha sido enviada. Nos pondremos en contacto contigo pronto.');
    }
}
