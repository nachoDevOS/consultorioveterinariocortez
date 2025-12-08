<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistersUserEvents;

class Appointment extends Model
{
    use HasFactory, RegistersUserEvents, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'service_id',
        'animal_id',
        'race_id',
        'nameClient',
        'phoneClient',
        'nameAnimal',
        'gender',
        'age',
        'date',
        'time',
        'file',
        'observation',
        'latitud',
        'longitud',
        'view',
        'status',
        'worker_id',

        'registerUser_id',
        'registerRole',
        'deleted_at',
        'deleteUser_id',
        'deleteRole',
        'deleteObservation',
    ];


    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function race()
    {
        return $this->belongsTo(Race::class, 'race_id');
    }

    public function appointmentWorkers()
    {
        return $this->hasMany(AppointmentWorker::class, 'appointment_id');
    }

}
