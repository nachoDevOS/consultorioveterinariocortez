<?php

namespace App\Http\Controllers;

use App\Models\AnamnesisForm;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnamnesisFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Pet $pet)
    {
        // 1. Validar los datos del formulario
        $validatedData = $request->validate([
            'date' => 'required|date',
            'reproductive_status' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'identification' => 'nullable|string|max:255',
            'main_problem' => 'nullable|string',
            'evolution_time' => 'nullable|string|max:255',
            'recent_changes' => 'nullable|string|max:255',
            'observed_signs' => 'nullable|string',
            'appetite' => 'required|string',
            'water_intake' => 'required|string',
            'activity' => 'required|string',
            'urination' => 'required|string',
            'defecation' => 'nullable|string|max:255',
            'temperature' => 'nullable|string|max:50',
            'heart_rate' => 'nullable|string|max:50',
            'respiratory_rate' => 'nullable|string|max:50',
            'previous_diseases' => 'nullable|string',
            'previous_surgeries' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'allergies' => 'nullable|string',
            'vaccines' => 'nullable|string',
            'deworming' => 'nullable|string',
            'diet_type' => 'nullable|string|max:255',
            'diet_brand' => 'nullable|string|max:255',
            'diet_frequency' => 'nullable|string|max:255',
            'diet_recent_changes' => 'nullable|string',
            'housing' => 'required|string',
            'access_to_exterior' => 'required|string',
            'stay_place' => 'nullable|string|max:255',
            'cohabiting_animals' => 'nullable|array',
            'cohabiting_animals.*' => 'exists:races,id', // Valida cada ID en el array
            'toxic_exposure' => 'nullable|string',
            'females_repro' => 'nullable|string',
            'males_repro' => 'nullable|string',
            'repro_complications' => 'nullable|string',
            'additional_observations' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // return $request;
            // 2. Crear el registro de Anamnesis
            $anamnesis = AnamnesisForm::create([
                'pet_id' => $pet->id,
                'doctor_id' => Auth::id(),

                'date' => $request->date,
                'reproductive_status' => $request->reproductive_status,
                'weight' => $request->weight,
                'identification' => $request->identification,   
                'main_problem' => $request->main_problem,
                'evolution_time' => $request->evolution_time,
                'recent_changes' => $request->recent_changes,
                'appetite' => $request->appetite,
                'water_intake' => $request->water_intake,
                'activity' => $request->activity,
                'urination'=> $request->urination,
                'defecation' => $request->defecation,
                'temperature' => $request->temperature,
                'heart_rate' => $request->heart_rate,
                'respiratory_rate' => $request->respiratory_rate,
                'previous_diseases' => $request->previous_diseases,
                'previous_surgeries' => $request->previous_surgeries,
                'current_medications' => $request->current_medications,
                'allergies' => $request->allergies,
                'vaccines' => $request->vaccines,
                'deworming' => $request->deworming,
                'diet_type' => $request->diet_type,
                'diet_brand' => $request->diet_brand,
                'diet_frequency' => $request->diet_frequency,
                'diet_recent_changes' => $request->diet_recent_changes,
                'housing' => $request->housing,
                'access_to_exterior' => $request->access_to_exterior,
                'stay_place' => $request->stay_place,
                'cohabiting_animals' => $request->cohabiting_animals ? json_encode($request->cohabiting_animals) : null,
                'toxic_exposure' => $request->toxic_exposure,
                'females_repro' => $request->females_repro,
                'males_repro' => $request->males_repro,
                'repro_complications' => $request->repro_complications,
                'additional_observations' => $request->additional_observations
            ]);

            DB::commit();

            return redirect()->route('voyager.pets.show', $pet->id)->with(['message' => 'Historial clínico guardado exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar el historial clínico');
            return redirect()->back()->with(['message' => 'Ocurrió un error al guardar el historial.', 'alert-type' => 'error'])->withInput();
        }
    }

    public function listByPet(Pet $pet)
    {
        // Opcional: puedes añadir un permiso específico para ver el historial
        // $this->custom_authorize('read_pet_histories');

        $search = request('search') ?? null;
        $paginate = request('paginate') ?? 5; // Paginamos de 5 en 5, puedes cambiarlo

        $data = AnamnesisForm::with(['doctor'])
            ->where('pet_id', $pet->id)
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('main_problem', 'like', "%$search%")
                      ->orWhere('date', 'like', "%$search%")
                      ->orWhereHas('doctor', function($query) use ($search) {
                          $query->where('name', 'like', "%$search%");
                      });
                });
            })
            ->orderBy('date', 'desc')
            ->paginate($paginate);
        return view('administrations.pets.history-list', compact('data', 'pet'));
    }
}
