<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class ReminderController extends Controller
{
    public function list($pet_id)
    {
        $search = request('search');
        $reminders = Reminder::with(['pet.person'])->where('pet_id', $pet_id)
            ->where(function($query) use ($search) {
                if ($search) {
                    $query->where('observation', 'like', "%$search%")
                          ->orWhere('date', 'like', "%$search%");
                }
            })
            ->orderBy('id', 'desc')
            ->paginate(5);
        
        // dump($reminders);
        // return 1;
        return view('administrations.pets.reminder-list', compact('reminders'));
    }

    public function store(Request $request)
    {
        try {
            Reminder::create([
                'pet_id' => $request->pet_id,
                'user_id' => Auth::id(),
                'date' => $request->date,
                'time' => $request->time,
                'observation' => $request->description,
            ]);
            return response()->json(['success' => true, 'message' => 'Recordatorio guardado exitosamente.']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Ocurrió un error al guardar el recordatorio.']);
        }
    }

    public function sendWhatsApp(Reminder $reminder)
    {
        try {
            // Cargar relaciones para tener todos los datos
            $reminder->load('pet.person');

            $owner = $reminder->pet->person;

            if (!$owner || !$owner->phone) {
                return response()->json(['success' => false, 'message' => 'El propietario no tiene un número de teléfono registrado.']);
            }

            // Obtener configuración de la API de WhatsApp desde los settings de Voyager
            $servidor = setting('solucion-digital.servidorWhatsapp');
            $sessionId = setting('solucion-digital.sessionWhatsapp');

            if (!$servidor || !$sessionId) {
                return response()->json(['success' => false, 'message' => 'La configuración para enviar WhatsApp no está completa en los ajustes del sistema.']);
            }

            // Limpiar y formatear el número de teléfono (asumiendo código de Bolivia 591)
            $phone = preg_replace('/[^0-9]/', '', $owner->phone);
            if (strlen($phone) == 8) {
                $phone = '591' . $phone;
            }

            // Construir el mensaje detallado
            $message = "Estimado/a " . strtoupper($owner->first_name) . " " . strtoupper($owner->paternal_surname) . " " . strtoupper($owner->maternal_surname) . ",\n\n" .
                       "Le recordamos la siguiente cita para su mascota *" . strtoupper($reminder->pet->name) . "*:\n\n" .
                       "📝 *Descripción:* " . $reminder->observation . "\n" .
                       "🗓️ *Fecha:* " . \Carbon\Carbon::parse($reminder->date)->format('d/m/Y') . "\n" .
                       "⏰ *Hora:* " . $reminder->time . "\n\n" .
                       "Gracias,\n*Clínica Veterinaria Cortez*";

            // Enviar la petición a la API
            Http::post($servidor . '/send?id=' . $sessionId . '&token=' . null, [
                'phone' => '+' . $phone,
                'text' => $message,
            ]);

            return response()->json(['success' => true, 'message' => 'Recordatorio enviado por WhatsApp exitosamente.']);
        } catch (\Exception $e) {
            Log::error('Error al enviar WhatsApp: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Ocurrió un error al enviar el recordatorio.']);
        }
    }

    public function destroy(Reminder $reminder)
    {
        try {
            $reminder->delete();
            return response()->json(['success' => true, 'message' => 'Recordatorio eliminado exitosamente.']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Ocurrió un error al eliminar el recordatorio.']);
        }
    }
}
