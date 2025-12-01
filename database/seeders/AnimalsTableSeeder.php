<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AnimalsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('animals')->delete();
        
        \DB::table('animals')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Perro',
                'observation' => NULL,
                'image' => NULL,
                'status' => 1,
                'created_at' => '2025-12-01 09:25:04',
                'updated_at' => '2025-12-01 09:25:04',
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
                'name' => 'Gato',
                'observation' => NULL,
                'image' => NULL,
                'status' => 1,
                'created_at' => '2025-12-01 09:25:10',
                'updated_at' => '2025-12-01 09:26:11',
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
                'name' => 'Ave',
                'observation' => NULL,
                'image' => NULL,
                'status' => 1,
                'created_at' => '2025-12-01 09:25:16',
                'updated_at' => '2025-12-01 09:25:31',
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
                'name' => 'Roedor',
                'observation' => NULL,
                'image' => NULL,
                'status' => 1,
                'created_at' => '2025-12-01 09:25:39',
                'updated_at' => '2025-12-01 09:25:39',
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
                'name' => 'Otros',
                'observation' => NULL,
                'image' => NULL,
                'status' => 1,
                'created_at' => '2025-12-01 09:26:03',
                'updated_at' => '2025-12-01 09:26:03',
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