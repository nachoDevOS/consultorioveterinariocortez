<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistersUserEvents;

class AnamnesisItemStock extends Model
{
    use HasFactory, RegistersUserEvents, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'anamnesisForm_id',
        'itemStock_id',
        'pricePurchase',

        'price',
        'quantity',
        'amount',
        'status',

        'registerUser_id',
        'registerRole',
        'deleted_at',
        'deleteUser_id',
        'deleteRole',
        'deleteObservation',
    ];

    public function anamnesisForm()
    {
        return $this->belongsTo(AnamnesisForm::class, 'anamnesisForm_id');
    }

    public function itemStock()
    {
        return $this->belongsTo(ItemStock::class, 'itemStock_id');
    }

    public function registerUser()
    {
        return $this->belongsTo(User::class, 'registerUser_id');
    }

}
