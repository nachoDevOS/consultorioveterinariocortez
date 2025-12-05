<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistersUserEvents;

class AnamnesisForm extends Model
{
    use HasFactory, RegistersUserEvents, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'pet_id',
        'doctor_id',
        'date',

        // IDENTIFICACIÓN DEL PACIENTE
        'reproductive_status',
        'weight',
        'identification',

        // MOTIVO DE CONSULTA
        'main_problem',
        'evolution_time',
        'recent_changes',

        // HISTORIA CLÍNICA ACTUAL
        'appetite',
        'observed_signs',
        'water_intake',
        'activity',
        'urination',
        'defecation',
        'temperature',
        'heart_rate',
        'respiratory_rate',

        // HISTORIA CLÍNICA PREVIA
        'previous_diseases',
        'previous_surgeries',
        'current_medications',
        'allergies',
        'vaccines',
        'deworming',

        // ALIMENTACIÓN
        'diet_type',
        'diet_brand',
        'diet_frequency',
        'diet_recent_changes',

        // AMBIENTE Y MANEJO
        'housing',
        'access_to_exterior',
        'stay_place',
        'cohabiting_animals',
        'toxic_exposure',

        // AMBIENTE Y MANEJO
        'females_repro',
        'males_repro',
        'repro_complications',

        // OBSERVACIONES ADICIONALES
        'additional_observations',

        'status',

        'registerUser_id',
        'registerRole',
        'deleted_at',
        'deleteUser_id',
        'deleteRole',
        'deleteObservation',
    ];
}
