<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistersUserEvents;

class IncomeDetail extends Model
{
    use HasFactory, RegistersUserEvents, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'income_id',
        'item_id',
        'lote',
        'quantity',
        'stock',
        'pricePurchase',
        'priceSale',
        'priceWhole',

        'amountPurchase',
        'amountSale',
        'amountWhole',
        // 'observation',

        'status',
        'registerUser_id',
        'registerRole',
        'deleted_at',
        'deleteUser_id',
        'deleteRole',
        'deleteObservation',
    ];

    public function income()
    {
        return $this->belongsTo(Income::class, 'income_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    

    public function itemStock()
    {
        return $this->hasMany(ItemStock::class, 'incomeDetail_id');
    }
}
