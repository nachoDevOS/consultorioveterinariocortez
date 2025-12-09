<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WorkersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('workers')->delete();
        
        \DB::table('workers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'ci' => '5618849',
                'first_name' => 'Diego',
                'middle_name' => 'Alejandro',
                'paternal_surname' => 'Cortez',
                'maternal_surname' => 'Gonzales',
                'birth_date' => '1989-02-25',
                'email' => NULL,
                'phone' => '74718561',
                'address' => 'Urbanización san Antonio',
                'gender' => 'Masculino',
                'image' => 'workers/December2025/Cg3WSEfUExTOdgLN9fYHday08pm.avif',
                'status' => 1,
                'created_at' => '2025-12-07 20:09:29',
                'updated_at' => '2025-12-08 16:20:19',
                'registerUser_id' => NULL,
                'registerRole' => NULL,
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'ci' => '5618850',
                'first_name' => 'francisco',
                'middle_name' => 'javier',
                'paternal_surname' => 'cortez',
                'maternal_surname' => 'gonzales',
                'birth_date' => '1993-12-11',
                'email' => NULL,
                'phone' => '74718561',
                'address' => NULL,
                'gender' => 'masculino',
                'image' => NULL,
                'status' => 1,
                'created_at' => '2025-12-08 16:08:08',
                'updated_at' => '2025-12-08 16:08:08',
                'registerUser_id' => NULL,
                'registerRole' => NULL,
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
        ));
        
        
    }
}