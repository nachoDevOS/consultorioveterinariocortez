<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('services')->delete();
        
        \DB::table('services')->insert(array (
            0 => 
            array (
                'id' => 1,
                'icon' => NULL,
                'name' => 'CONSULTAS VETERINARIAS',
                'observation' => 'Exámenes de salud completos, diagnóstico y tratamiento para mantener a tu mascota saludable.',
                'status' => 1,
                'created_at' => '2025-12-01 12:45:03',
                'updated_at' => '2025-12-01 15:53:27',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'icon' => NULL,
                'name' => 'BAÑO Y PELUQUERIA',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-01 12:45:26',
                'updated_at' => '2025-12-01 12:45:34',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'icon' => NULL,
                'name' => 'VACUNA Y DESPARACITACION',
                'observation' => 'Programas de vacunación personalizados para proteger a tu mascota de enfermedades comunes.',
                'status' => 1,
                'created_at' => '2025-12-01 12:46:05',
                'updated_at' => '2025-12-01 15:51:06',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'icon' => NULL,
                'name' => 'CIRUGIAS',
                'observation' => 'Procedimientos quirúrgicos con equipos de última generación y anestesia segura.',
                'status' => 1,
                'created_at' => '2025-12-01 12:46:24',
                'updated_at' => '2025-12-01 15:53:46',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'icon' => NULL,
                'name' => 'URGENCIAS',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-01 12:46:34',
                'updated_at' => '2025-12-01 12:46:34',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
        ));
        
        
    }
}