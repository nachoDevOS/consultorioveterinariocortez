<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('suppliers')->delete();
        
        \DB::table('suppliers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nit' => '7633685015',
                'name' => 'Medical',
                'phone' => NULL,
                'email' => NULL,
                'address' => NULL,
                'status' => 1,
                'observation' => NULL,
                'created_at' => '2025-12-04 15:12:31',
                'updated_at' => '2025-12-04 15:12:31',
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