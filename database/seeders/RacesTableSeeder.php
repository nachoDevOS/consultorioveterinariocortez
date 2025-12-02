<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RacesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('races')->delete();
        
        \DB::table('races')->insert(array (
            0 => 
            array (
                'id' => 1,
                'animal_id' => 1,
                'name' => 'Pastor Alemán',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:19:12',
                'updated_at' => '2025-12-02 17:19:12',
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
                'animal_id' => 1,
                'name' => 'Labrador Retriever',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:22:21',
                'updated_at' => '2025-12-02 17:22:21',
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
                'animal_id' => 1,
                'name' => 'Bulldog Francés',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:22:30',
                'updated_at' => '2025-12-02 17:22:30',
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
                'animal_id' => 1,
                'name' => 'Poodle',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:22:46',
                'updated_at' => '2025-12-02 17:22:46',
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
                'animal_id' => 1,
                'name' => 'Schnauzer',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:22:56',
                'updated_at' => '2025-12-02 17:22:56',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'animal_id' => 1,
                'name' => 'Rottweiler',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:23:03',
                'updated_at' => '2025-12-02 17:23:03',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'animal_id' => 1,
                'name' => 'Pitbull',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:23:09',
                'updated_at' => '2025-12-02 17:23:09',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'animal_id' => 2,
                'name' => 'Persa',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:23:28',
                'updated_at' => '2025-12-02 17:23:28',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'animal_id' => 2,
                'name' => 'Siames',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:23:33',
                'updated_at' => '2025-12-02 17:23:33',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'animal_id' => 2,
                'name' => 'Angora',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:23:41',
                'updated_at' => '2025-12-02 17:23:41',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'animal_id' => 2,
                'name' => 'Maine Coon',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:23:49',
                'updated_at' => '2025-12-02 17:23:49',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'animal_id' => 5,
                'name' => 'Percherón',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:24:36',
                'updated_at' => '2025-12-02 17:24:36',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'animal_id' => 5,
                'name' => 'Bretón',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:24:44',
                'updated_at' => '2025-12-02 17:24:44',
                'registerUser_id' => 1,
                'registerRole' => 'admin',
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'animal_id' => 5,
                'name' => 'Poni',
                'observation' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 17:24:50',
                'updated_at' => '2025-12-02 17:24:50',
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