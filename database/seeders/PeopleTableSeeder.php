<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PeopleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('people')->delete();
        
        \DB::table('people')->insert(array (
            0 => 
            array (
                'id' => 1,
                'ci' => '7633666',
                'first_name' => 'Ignacio',
                'middle_name' => NULL,
                'paternal_surname' => 'Molina',
                'maternal_surname' => 'Guzman',
                'birth_date' => '1997-03-08',
                'email' => 'ignaciomolinaguzman20@gmail.com',
                'phone' => '67285914',
                'address' => 'Trinidad',
                'gender' => 'Masculino',
                'image' => NULL,
                'status' => 1,
                'created_at' => '2025-12-02 22:10:29',
                'updated_at' => '2025-12-02 22:10:29',
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