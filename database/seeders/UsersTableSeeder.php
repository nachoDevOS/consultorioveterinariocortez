<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'role_id' => 1,
                'name' => 'Admin',
                'email' => 'admin@soluciondigital.dev',
                'avatar' => 'users/default.png',
                'email_verified_at' => NULL,
                'password' => '$2y$10$dAgeq5dRhm2UblYq81.VtetxG.zuEwQSlgObtGlin/0/GItYt0pIK',
                'remember_token' => 'oTdu09WhFIyphCrZSWgVr8cWkDVdEjtku2GrbV3IgBB4nWFyMzfIxLZUwkYY',
                'settings' => '{"locale":"es"}',
                'created_at' => '2024-10-18 10:28:45',
                'updated_at' => '2025-12-08 15:47:19',
                'status' => 1,
                'worker_id' => NULL,
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
                'role_id' => 2,
                'name' => 'Diego Alejandro Cortez Gonzales',
                'email' => 'diego.cortez@admin.com',
                'avatar' => 'users/default.png',
                'email_verified_at' => NULL,
                'password' => '$2y$10$ILLZfhsbwinK3235ceVa7O0mj3M5fr33wb3z28aDqiBWLwBfSUzYy',
                'remember_token' => 'BVYWJsmqNr9YZbGTgcvD8jqcqTlkpYlvMTMoyiKdPbL5edIDckN7BCjobBCk',
                'settings' => '{"locale":"es"}',
                'created_at' => '2024-10-18 10:28:45',
                'updated_at' => '2024-10-18 10:33:30',
                'status' => 1,
                'worker_id' => 1,
                'registerUser_id' => NULL,
                'registerRole' => NULL,
                'deleted_at' => NULL,
                'deleteUser_id' => NULL,
                'deleteRole' => NULL,
                'deleteObservation' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'role_id' => 2,
                'name' => 'francisco javier cortez gonzales',
                'email' => 'dieguitokmbita@gmail.com',
                'avatar' => 'users/default.png',
                'email_verified_at' => NULL,
                'password' => '$2y$10$L68ucQh2p4Va/FmA9M.iwumQNUNRMLkvOtzRXULUJGFlNCt/2GdAO',
                'remember_token' => NULL,
                'settings' => NULL,
                'created_at' => '2025-12-08 16:19:13',
                'updated_at' => '2025-12-08 16:19:13',
                'status' => 1,
                'worker_id' => 2,
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