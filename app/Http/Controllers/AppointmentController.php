<?php

namespace App\Http\Controllers;

use App\Jobs\WhatsappJob;
use App\Models\Worker;
use App\Models\Appointment;
use App\Models\AppointmentWorker;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public $storageController;
    public function __construct()
    {
        $this->middleware('auth');
        $this->storageController = new StorageController();
    }

    public function index()
    {
        $this->custom_authorize('browse_appointments');

        return view('appointments.browse');
    }
    
    public function list(){

        $search = request('search') ?? null;
        $status = request('status') ?? null;
        $paginate = request('paginate') ?? 10;

        $data = Appointment::with(['service', 'animal', 'race'])
            ->where(function ($query) use ($search) {
                if($search){
                    $query->whereHas('service', function($query) use($search){
                        $query->whereRaw("name like '%$search%'");
                    })
                    ->OrwhereHas('animal', function($query) use($search){
                        $query->whereRaw("name like '%$search%'");
                    })
                    ->OrWhereRaw($search ? "id = '$search'" : 1)
                    ->OrWhereRaw($search ? "nameClient like '%$search%'" : 1)
                    ->OrWhereRaw($search ? "phoneClient like '%$search%'" : 1)
                    ->OrWhereRaw($search ? "gender like '%$search%'" : 1)
                    ->OrWhereRaw($search ? "age like '%$search%'" : 1)
                    ->OrWhereRaw($search ? "observation like '%$search%'" : 1);
                }
            })
            ->where('deleted_at', null)
            ->whereRaw($status ? "status = '$status'" : 1)
            ->orderBy('id', 'DESC')
            ->paginate($paginate);



        return view('appointments.list', compact('data'));
    }

    public function show($id)
    {
        $this->custom_authorize('read_appointments');

        $appointment = Appointment::with(['service', 'animal', 'race', 'worker', 'appointmentWorkers.worker'])->findOrFail($id);
        $appointment->update(['view'=> 1]);

        // Obtener todos los trabajadores activos para el modal
        $workers = Worker::where('status', 1)->get();

        // Obtener la asignación actual si existe
        $workerAssignment = AppointmentWorker::where('appointment_id', $id)->first();

        return Voyager::view('appointments.read', compact('appointment', 'workers', 'workerAssignment'));
    }

    public function destroy($id)
    {
        $this->custom_authorize('delete_appointments');

        DB::beginTransaction();
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->delete();

            DB::commit();
            return redirect()->route('voyager.appointments.index')->with(['message' => 'Cita eliminada exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar cita: ' . $e->getMessage());
            return redirect()->route('voyager.appointments.index')->with(['message' => 'Ocurrió un error al eliminar la cita.', 'alert-type' => 'error']);
        }
    }

    public function resend(Request $request, $id)
    {
        $this->custom_authorize('read_appointments'); // O un permiso más específico si lo deseas

        $request->validate([
            'phone_number' => 'required|digits:8',
        ]);

        try {
            $appointment = Appointment::with(['service', 'animal', 'race'])->findOrFail($id);

            // Construir el mensaje detallado para WhatsApp
            $message = "🗓️ *Recordatorio de Cita* 🗓️\n\n" .
                "Hola, te reenviamos los detalles de tu cita en la Clínica Veterinaria Cortez:\n\n" .
                "👤 *Cliente:* {$appointment->nameClient}\n" .
                "📞 *Teléfono Original:* {$appointment->phoneClient}\n\n" .
                "🐾 *Mascota:*\n" .
                "   - *Nombre:* {$appointment->nameAnimal}\n" .
                "   - *Tipo:* {$appointment->animal->name}\n" .
                "   - *Raza:* " . ($appointment->race->name ?? 'No especificada') . "\n" .
                "   - *Género:* {$appointment->gender}\n\n" .
                "🩺 *Servicio Solicitado:*\n" .
                "   - {$appointment->service->name}\n\n" .
                "🗓️ *Fecha y Hora:*\n" .
                "   - " . \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') . " a las " . \Carbon\Carbon::parse($appointment->time)->format('H:i') . "\n\n" .
                "📝 *Observaciones:*\n" .
                "_{$appointment->observation}_\n\n";

            if ($appointment->latitud && $appointment->longitud) {
                $message .= "📍 *Ubicación de la Cita:*\n" .
                    "   - Ver en mapa: https://www.google.com/maps?q={$appointment->latitud},{$appointment->longitud}\n\n";
            }

            $message .= "\n\n*Contacto Directo:*\n" .
            "Haz clic para contactar al cliente: https://wa.me/591{$appointment->phoneClient}";


            $servidor = setting('whatsapp.servidores');
            $sessionId = setting('whatsapp.session');

            if($request->phone_number && $servidor && $sessionId)
            {
                WhatsappJob::dispatch($servidor, $sessionId, '+591'.$request->phone_number, $message, 'Reenvio de Cita');
            }

            return redirect()->back()->with(['message' => 'La cita ha sido reenviada por WhatsApp exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            \Log::error('Error al reenviar cita por WhatsApp: ' . $e->getMessage());
            return redirect()->back()->with(['message' => 'Ocurrió un error al intentar reenviar la cita.', 'alert-type' => 'error']);
        }
    }

    public function assignWorker(Request $request, $id)
    {
        $this->custom_authorize('edit_appointments');

        $request->validate([
            'worker_id' => 'required|exists:workers,id',
        ]);

        DB::beginTransaction();
        try {
            // Verificar si ya existe una asignación para esta cita
            // $assignment = AppointmentWorker::where('appointment_id', $id)->first();
            $appointment = Appointment::findOrFail($id);
            $appointment->update([
                'worker_id' => $request->worker_id,
                'type' => $request->type,
                'status'=> 'Asignado'
            ]);


            // Usar updateOrCreate para simplificar la lógica de asignación
            AppointmentWorker::create(
                [
                    'appointment_id' => $id,
                    'worker_id' => $request->worker_id,
                    'observation' => $request->observation
                ]
            );

            // Enviar notificación de confirmación al cliente
            $worker = Worker::findOrFail($request->worker_id);
            $clientPhone = $appointment->phoneClient;


            $servidor = setting('whatsapp.servidores');
            $sessionId = setting('whatsapp.session');

            $clientName = ucwords(strtolower($appointment->nameClient));
            $petName = ucwords(strtolower($appointment->nameAnimal));
            $workerName = ucwords(strtolower($worker->first_name.' '.$worker->paternal_surname));
            $clinicName = setting('admin.title');
            $appointmentDate = \Carbon\Carbon::parse($appointment->date)->format('d/m/Y');
            $appointmentTime = \Carbon\Carbon::parse($appointment->time)->format('h:i A');

            $detailsMessage = '';
            if ($request->type == 'Domicilio') {
                $detailsMessage = "El Dr(a). *{$workerName}*, uno de nuestros especialistas, pasará por tu domicilio para atender con mucho cariño a tu fiel amigo(a).\n\n";
            } else { // Asumimos 'Consultorio' o cualquier otro caso
                $detailsMessage = "El Dr(a). *{$workerName}*, uno de nuestros especialistas, estará esperando con mucho cariño en nuestras instalaciones para atender a tu fiel amigo(a).\n\n";
            }

            $message = "¡Hola, {$clientName}! 👋\n\n" .
                        "¡Excelentes noticias! ✨ Tu cita en *{$clinicName}* para el cuidado de *{$petName}* ha sido *CONFIRMADA*.\n\n" .
                        $detailsMessage .
                        "Aquí están los detalles de tu cita:\n" .
                        "🗓️ *Fecha:* {$appointmentDate}\n" .
                        "⏰ *Hora:* {$appointmentTime}\n\n" .
                        "Estamos muy contentos de que confíes en nosotros para el bienestar de *{$petName}*. ¡Nos vemos pronto!\n\n" .
                        "Atentamente,\nEl equipo de *{$clinicName}* 🐾";



            if($clientPhone && $servidor && $sessionId)
            {
                WhatsappJob::dispatch($servidor, $sessionId, '+591'.$clientPhone, $message, 'Confirmación de Cita');
            }



            $appointment = Appointment::with(['service', 'animal', 'race'])->findOrFail($id);

            // Construir el mensaje detallado para WhatsApp
            $message = "🗓️ *Recordatorio de Cita* 🗓️\n\n" .
                "Hola, te reenviamos los detalles de tu cita en la Clínica Veterinaria Cortez:\n\n" .
                "👤 *Cliente:* {$appointment->nameClient}\n" .
                "📞 *Teléfono Original:* {$appointment->phoneClient}\n\n" .
                "🐾 *Mascota:*\n" .
                "   - *Nombre:* {$appointment->nameAnimal}\n" .
                "   - *Tipo:* {$appointment->animal->name}\n" .
                "   - *Raza:* " . ($appointment->race->name ?? 'No especificada') . "\n" .
                "   - *Género:* {$appointment->gender}\n\n" .
                "🩺 *Servicio Solicitado:*\n" .
                "   - {$appointment->service->name}\n\n" .
                "🗓️ *Fecha y Hora:*\n" .
                "   - " . \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') . " a las " . \Carbon\Carbon::parse($appointment->time)->format('H:i') . "\n\n" .
                "📝 *Observaciones:*\n" .
                "_{$appointment->observation}_\n\n";

            if ($appointment->latitud && $appointment->longitud) {
                $message .= "📍 *Ubicación de la Cita:*\n" .
                    "   - Ver en mapa: https://www.google.com/maps?q={$appointment->latitud},{$appointment->longitud}\n\n";
            }


            $message .= "\n\n*Contacto Directo:*\n" .
            "Haz clic para contactar al cliente: https://wa.me/591{$appointment->phoneClient}";


            if($worker->phone && $servidor && $sessionId)
            {
                WhatsappJob::dispatch($servidor, $sessionId, '+591'.$worker->phone, $message, 'Reenvio de Cita');
            }


            DB::commit();
            return redirect()->back()->with(['message' => 'Trabajador asignado y cliente notificado exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al asignar trabajador: ' . $e->getMessage());
            return redirect()->back()->with(['message' => 'Ocurrió un error al asignar el trabajador.', 'alert-type' => 'error']);
        }
    }


}
