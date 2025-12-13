<?php

namespace App\Http\Controllers;

use App\Jobs\WhatsappJob;
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
            $servidor = setting('whatsapp.servidores');
            $sessionId = setting('whatsapp.session');

            if (!$servidor || !$sessionId) {
                return response()->json(['success' => false, 'message' => 'La configuración para enviar WhatsApp no está completa en los ajustes del sistema.']);
            }

            // Construir el mensaje detallado
            $ownerName = ucwords(strtolower($owner->first_name.' '.$owner->paternal_surname));
            $petName = ucwords(strtolower($reminder->pet->name));
            $clinicName = setting('admin.title');

            $message = "¡Hola, {$ownerName}! 👋\n\n" .
                       "En *{$clinicName}* sabemos que el bienestar de *{$petName}* es lo más importante para ti, ¡y para nosotros también! ❤️\n\n" .
                       "Te enviamos un recordatorio amigable sobre su próximo cuidado:\n\n" .
                       "📝 *Motivo:* {$reminder->observation}\n" .
                       "🗓️ *Fecha:* " . \Carbon\Carbon::parse($reminder->date)->format('d/m/Y') . "\n" .
                       "⏰ *Hora:* " . \Carbon\Carbon::parse($reminder->time)->format('h:i A') . "\n\n" .
                       "¡Los esperamos con mucho cariño para seguir cuidando de tu mascota!\n\n" .
                       "Atentamente,\n*El equipo de {$clinicName}* 🐾";

            if($owner->phone && $servidor && $sessionId)
            {
                WhatsappJob::dispatch($servidor, $sessionId, '+591'.$owner->phone, $message, 'Envio de Recordatorio');
            }

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
