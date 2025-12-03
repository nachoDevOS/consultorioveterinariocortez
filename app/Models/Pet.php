<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistersUserEvents;

class Pet extends Model
{
    use HasFactory, RegistersUserEvents, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'person_id',
        'animal_id',
        'race_id',
        'name',
        'color',
        'birthdate',
        'gender',
        'image',
        'status',

        'registerUser_id',
        'registerRole',
        'deleted_at',
        'deleteUser_id',
        'deleteRole',
        'deleteObservation',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }
    public function race()
    {
        return $this->belongsTo(Race::class, 'race_id');
    }
    public function registerUser()
    {
        return $this->belongsTo(User::class, 'registerUser_id');
    }
}
