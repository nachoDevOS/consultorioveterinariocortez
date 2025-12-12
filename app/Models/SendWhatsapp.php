<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendWhatsapp extends Model
{
    use HasFactory;
    protected $fillable = [
        'server',
        'session',
        'phone',
        'message',
        'type',
        'status',
    ];
}
