<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(){
        $animals = Animal::where('deleted_at', null)->get();
        return view('welcome', compact('animals'));
    }

    // Nuevo método para guardar la cita
    public function storeAppointment(Request $request)
    {
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'pet_name' => 'required|string|max:255',
            'pet_type' => 'required|string',
            'service' => 'required|string',
            'message' => 'required|string',
            'terms' => 'accepted'
        ]);

        // Guardamos la información en el log de Laravel
        // En el futuro, aquí puedes agregar el código para guardar en la base de datos
        Log::info('Nueva solicitud de cita:', $validatedData);

        // Redirigir de vuelta a la página anterior con un mensaje de éxito
        return back()->with('success', '¡Gracias! Tu solicitud de cita ha sido enviada. Nos pondremos en contacto contigo pronto.');
    }
}
