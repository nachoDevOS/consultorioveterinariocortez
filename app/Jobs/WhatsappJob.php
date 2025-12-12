<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;          
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SendWhatsapp;
use Illuminate\Support\Facades\Http;


class WhatsappJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $server;
    protected $session;
    protected $phone;
    protected $message;
    protected $type;

    public function __construct($server, $session ,$phone, $message, $type)
    {
        $this->server = $server;
        $this->session = $session;
        $this->phone = $phone;
        $this->message = $message;
        $this->type = $type;
    }

    public function handle()
    {
        $urlStatus = $this->server.'/status?id='.$this->session;
        $response = Http::get($urlStatus)->json();

        if($response['success'] == true) {
            if($response['status'] == true) {                
                    $url = $this->server.'/send?id='.$this->session.'&token='.null;
                    $responseSend = Http::post($url, [
                        'phone' => $this->phone,
                        'text' => $this->message,
                    ])->json();

                    if($responseSend['success'] == true) {
                        $this->bd($this->server, $this->session, $this->phone, $this->message, $this->type, 'Enviado');
                    } else {
                        $this->bd($this->server, $this->session, $this->phone, $this->message, $this->type, 'No Enviado');
                    }
            } else {
                    $this->bd($this->server, $this->session, $this->phone, $this->message, $this->type, 'Servidor Fuera de Línea');
            }
        }
        sleep(rand(15, 25));
    }

    public function bd($server, $session ,$phone, $message, $type, $status)
    {
        $send = new SendWhatsapp();
        $send->server = $server;
        $send->session = $session;
        $send->phone = $phone;
        $send->message = $message;
        $send->type = $type;
        $send->status = $status;
        $send->save();
    }
}
