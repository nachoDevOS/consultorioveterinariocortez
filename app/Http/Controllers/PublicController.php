<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Jobs\SendWhatsapp;

class PublicController extends Controller
{
    public function reminderNotificate()
    {
        $reminder = Reminder::with(['pet.person'])
                ->where('deleted_at', null)
                ->whereDate('date', '=', date('Y-m-d'))
                ->get();

        $url = 'https://whatsapp-serve.soluciondigital.dev/status?id=prueba';

        
        $response = Http::get($url)->json();


        return $response['status'];


        
                

        

        
        return response()->json($reminder);
    }


    function updateStatus($status) {
    if ($status == 'online') {
        echo "✅ Estado actualizado: EN LÍNEA<br>";
        // Aquí tu lógica para estado online
    } else {
        echo "❌ Estado actualizado: OFFLINE<br>";
        // Aquí tu lógica para estado offline
    }
}
}
