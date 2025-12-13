<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'site.title',
                'display_name' => 'Título del sitio',
                'value' => 'Consultorio Veterinario Cortez',
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Site',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'site.description',
                'display_name' => 'Descripción del sitio',
                'value' => 'Cuidando a tus mascotas con amor y profesionalismo',
                'details' => '',
                'type' => 'text',
                'order' => 2,
                'group' => 'Site',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'site.logo',
                'display_name' => 'Logo del sitio',
                'value' => 'settings/December2025/WhWVZ9KYFapWEmQ6YzQA.png',
                'details' => '',
                'type' => 'image',
                'order' => 3,
                'group' => 'Site',
            ),
            3 => 
            array (
                'id' => 5,
                'key' => 'admin.bg_image',
                'display_name' => 'Imagen de fondo del administrador',
                'value' => 'settings/December2025/kvCuEuNp9qEoxFWxchGk.png',
                'details' => '',
                'type' => 'image',
                'order' => 5,
                'group' => 'Admin',
            ),
            4 => 
            array (
                'id' => 6,
                'key' => 'admin.title',
                'display_name' => 'Título del administrador',
                'value' => 'Consultorio Veterinario Cortez',
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Admin',
            ),
            5 => 
            array (
                'id' => 7,
                'key' => 'admin.description',
                'display_name' => 'Descripción del administrador',
                'value' => 'Cuidando a tus mascotas con amor y profesionalismo',
                'details' => '',
                'type' => 'text',
                'order' => 2,
                'group' => 'Admin',
            ),
            6 => 
            array (
                'id' => 8,
                'key' => 'admin.loader',
                'display_name' => 'Imagen de carga del administrador',
                'value' => 'settings/December2025/VNtJIsmeYIU0o0pFyQ2F.jpeg',
                'details' => '',
                'type' => 'image',
                'order' => 3,
                'group' => 'Admin',
            ),
            7 => 
            array (
                'id' => 9,
                'key' => 'admin.icon_image',
                'display_name' => 'Ícono del administrador',
                'value' => 'settings/December2025/ZNLp2IifLVqxLE6mAflI.png',
                'details' => '',
                'type' => 'image',
                'order' => 4,
                'group' => 'Admin',
            ),
            8 => 
            array (
                'id' => 11,
                'key' => 'system.development',
                'display_name' => 'Sistema en Mantenimiento 503',
                'value' => '0',
                'details' => NULL,
                'type' => 'checkbox',
                'order' => 1,
                'group' => 'System',
            ),
            9 => 
            array (
                'id' => 12,
                'key' => 'system.payment-alert',
                'display_name' => 'Alerta de Pago',
                'value' => '1',
                'details' => NULL,
                'type' => 'checkbox',
                'order' => 1,
                'group' => 'System',
            ),
            10 => 
            array (
                'id' => 13,
                'key' => 'system.code-system',
                'display_name' => 'Código del Sistema',
                'value' => 'https://consultorioveterinariocortez.com',
                'details' => NULL,
                'type' => 'text',
                'order' => 2,
                'group' => 'System',
            ),
            11 => 
            array (
                'id' => 14,
                'key' => 'whatsapp.servidores',
                'display_name' => 'Servidor',
                'value' => 'https://whatsapp-serve.soluciondigital.dev',
                'details' => NULL,
                'type' => 'text',
                'order' => 6,
                'group' => 'Whatsapp',
            ),
            12 => 
            array (
                'id' => 16,
                'key' => 'whatsapp.session',
                'display_name' => 'Session',
                'value' => 'consultorio-veterinario-cortez',
                'details' => NULL,
                'type' => 'text',
                'order' => 7,
                'group' => 'Whatsapp',
            ),
            13 => 
            array (
                'id' => 17,
                'key' => 'redes-sociales.whatsapp',
                'display_name' => 'Whatsapp',
                'value' => '72849954',
                'details' => NULL,
                'type' => 'text',
                'order' => 8,
                'group' => 'Redes Sociales',
            ),
            14 => 
            array (
                'id' => 18,
                'key' => 'redes-sociales.facebook',
                'display_name' => 'Facebook',
                'value' => 'https://www.facebook.com/profile.php?id=61584847768789',
                'details' => NULL,
                'type' => 'text',
                'order' => 9,
                'group' => 'Redes Sociales',
            ),
            15 => 
            array (
                'id' => 19,
                'key' => 'redes-sociales.instagram',
                'display_name' => 'Instagram',
                'value' => 'https://www.instagram.com/consultoriocvz/',
                'details' => NULL,
                'type' => 'text',
                'order' => 10,
                'group' => 'Redes Sociales',
            ),
            16 => 
            array (
                'id' => 20,
                'key' => 'redes-sociales.tiktok',
                'display_name' => 'Tik Tok',
                'value' => NULL,
                'details' => NULL,
                'type' => 'text',
                'order' => 11,
                'group' => 'Redes Sociales',
            ),
            17 => 
            array (
                'id' => 21,
                'key' => 'redes-sociales.telegram',
                'display_name' => 'Telegram',
                'value' => NULL,
                'details' => NULL,
                'type' => 'text',
                'order' => 12,
                'group' => 'Redes Sociales',
            ),
            18 => 
            array (
                'id' => 22,
                'key' => 'redes-sociales.youtube',
                'display_name' => 'YouTube',
                'value' => NULL,
                'details' => NULL,
                'type' => 'text',
                'order' => 14,
                'group' => 'Redes Sociales',
            ),
            19 => 
            array (
                'id' => 23,
                'key' => 'redes-sociales.twitter',
                'display_name' => 'Twitter',
                'value' => NULL,
                'details' => NULL,
                'type' => 'text',
                'order' => 13,
                'group' => 'Redes Sociales',
            ),
            20 => 
            array (
                'id' => 24,
                'key' => 'servidor-imagen.image-from-url',
                'display_name' => 'Servidor',
                'value' => NULL,
                'details' => NULL,
                'type' => 'text',
                'order' => 15,
                'group' => 'Servidor Imagen',
            ),
            21 => 
            array (
                'id' => 25,
                'key' => 'site.address',
                'display_name' => 'Dirección',
                'value' => 'Urb. Universitartia Calle #3 Paralelo Cambodromo frente Jardin Infantil Pequeños Gigantes',
                'details' => NULL,
                'type' => 'text',
                'order' => 16,
                'group' => 'Site',
            ),
            22 => 
            array (
                'id' => 26,
                'key' => 'solucion-digital.servidorWhatsapp',
                'display_name' => 'Whatsapp Servidor',
                'value' => 'https://whatsapp-serve.soluciondigital.dev',
                'details' => NULL,
                'type' => 'text',
                'order' => 17,
                'group' => 'Solucion Digital',
            ),
            23 => 
            array (
                'id' => 27,
                'key' => 'solucion-digital.sessionWhatsapp',
                'display_name' => 'Whatsapp Session',
                'value' => 'soluciondigital-dev',
                'details' => NULL,
                'type' => 'text',
                'order' => 18,
                'group' => 'Solucion Digital',
            ),
            24 => 
            array (
                'id' => 28,
                'key' => 'system.mapsToken',
                'display_name' => 'Token Maps',
                'value' => 'pk.eyJ1IjoibmFjaG9kZXZvcyIsImEiOiJjbWlxd3g4bHAwbHZ1M2Rwd2Q4cTd1dzZkIn0.3IMokfY8ZTFfoBJQO35yLw',
                'details' => NULL,
                'type' => 'text',
                'order' => 19,
                'group' => 'System',
            ),
            25 => 
            array (
                'id' => 29,
                'key' => 'system.reCaptchaKeySite',
                'display_name' => 'reCAPTCHA Clave Sitio',
                'value' => '6LcsYCYsAAAAAJSG5_fy8OGwr5C075ZvXc6R0d2X',
                'details' => NULL,
                'type' => 'text',
                'order' => 20,
                'group' => 'System',
            ),
            26 => 
            array (
                'id' => 30,
                'key' => 'system.reCaptchaKeySecret',
                'display_name' => 'reCAPTCHA Clave Secreta',
                'value' => '6LcsYCYsAAAAAPT9_ET9HJh3dgOyb5MxODBB0WAZ',
                'details' => NULL,
                'type' => 'text',
                'order' => 21,
                'group' => 'System',
            ),
            27 => 
            array (
                'id' => 31,
                'key' => 'admin.customer',
                'display_name' => 'Venta a Clientes',
                'value' => '1',
                'details' => '{"on": "Activo","off": "Inactivo","checked": true}',
                'type' => 'checkbox',
                'order' => 22,
                'group' => 'Admin',
            ),
        ));
        
        
    }
}