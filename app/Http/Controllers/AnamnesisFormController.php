<?php

namespace App\Http\Controllers;

use App\Models\AnamnesisForm;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnamnesisFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created AnamnesisForm in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Pet $pet)
    {
        // 1. Validate the incoming request data
        $request->validate([
            'date' => 'required|date',
            'reproductive_status' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric',
            'identification' => 'nullable|string|max:255',
            'main_problem' => 'nullable|string',
            'observed_signs' => 'nullable|string',
            'evolution_time' => 'nullable|string|max:255',
            'recent_changes' => 'nullable|string|max:255',
            'appetite' => 'required|string|max:255',
            'water_intake' => 'required|string|max:255',
            'activity' => 'required|string|max:255',
            'urination' => 'required|string|max:255',
            'defecation' => 'nullable|string|max:255',
            'temperature' => 'nullable|string|max:255',
            'heart_rate' => 'nullable|string|max:255',
            'respiratory_rate' => 'nullable|string|max:255',
            'previous_diseases' => 'nullable|string',
            'previous_surgeries' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'allergies' => 'nullable|string',
            'vaccines' => 'nullable|string',
            'deworming' => 'nullable|string',
            'diet_type' => 'nullable|string|max:255',
            'diet_brand' => 'nullable|string|max:255',
            'diet_frequency' => 'nullable|string|max:255',
            'diet_recent_changes' => 'nullable|string|max:255',
            'housing' => 'required|string|max:255',
            'access_to_exterior' => 'required|string|max:255',
            'stay_place' => 'nullable|string|max:255',
            'cohabiting_animals' => 'nullable|string|max:255',
            'toxic_exposure' => 'nullable|string',
            'females_repro' => 'nullable|string',
            'males_repro' => 'nullable|string',
            'repro_complications' => 'nullable|string',
            'additional_observations' => 'nullable|string',
        ]);

        $anamnesisForm = new AnamnesisForm();
        $anamnesisForm->fill($request->except(['_token', '_method', 'owner_name', 'owner_phone', 'owner_address', 'vet_name', 'pet_name', 'pet_species', 'pet_race', 'pet_age', 'pet_gender']));
        $anamnesisForm->pet_id = $pet->id;
        $anamnesisForm->doctor_id = Auth::id();
        $anamnesisForm->registerUser_id = Auth::id();
        $anamnesisForm->registerRole = Auth::user()->role_id; // Asumiendo que el usuario tiene un campo 'role_id'
        $anamnesisForm->status = 'active'; // Establece un estado por defecto
        $anamnesisForm->save();

        return redirect()->route('voyager.pets.edit', $pet->id)->with([
            'message'    => 'Historial clínico guardado exitosamente.',
            'alert-type' => 'success',
        ]);
    }
}
