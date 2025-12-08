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
                'image' => NULL,
                'status' => 1,
                'created_at' => '2025-12-08 00:09:29',
                'updated_at' => '2025-12-08 00:10:46',
                'registerUser_id' => null,
                'registerRole' => null,
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
        ));
        
        
    }
}