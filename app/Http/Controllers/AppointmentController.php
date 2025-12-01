<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        // $this->custom_authorize('browse_appointments');

        return view('appointments.browse');
    }
    
    public function list(){

        $search = request('search') ?? null;
        $paginate = request('paginate') ?? 10;

        // 1. Iniciar el temporizador
        $startTime = microtime(true);

        $data = Person::query()
            // El método when() hace lo mismo que tu "if($search)"
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('id', $search)
                      ->orWhere('ci', 'like', "%$search%")
                      ->orWhere('phone', 'like', "%$search%")
                      ->orWhere(DB::raw("CONCAT(first_name, ' ', COALESCE(paternal_surname, ''), ' ', COALESCE(maternal_surname, ''))"), 'like', "%$search%")
                      ->orWhere(DB::raw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', COALESCE(paternal_surname, ''), ' ', COALESCE(maternal_surname, ''))"), 'like', "%$search%");
                });
            })
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->paginate($paginate);

        // 2. Finalizar el temporizador y calcular la duración
        $endTime = microtime(true);
        $duration = ($endTime - $startTime) * 1000;

        Log::channel('time')->info("Tiempo de consulta en PersonController@list: {$duration} ms");

        return view('administrations.people.list', compact('data'));
    }


}
