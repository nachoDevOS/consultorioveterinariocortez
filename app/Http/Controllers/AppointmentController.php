<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
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

        $appointment = Appointment::with(['service', 'animal', 'race'])->findOrFail($id);
        $appointment->update(['view'=> 1]);
        // $this->authorize('read', $appointment);
        return Voyager::view('appointments.read', compact('appointment'));
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


}
