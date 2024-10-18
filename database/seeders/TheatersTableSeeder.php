<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TheatersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('theaters')->delete();
        
        \DB::table('theaters')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'AMC',
                'city' => 'Phoenix',
                'state' => 'AZ',
                'created_at' => '2024-10-18 06:37:05',
                'updated_at' => '2024-10-18 06:37:05',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Regal',
                'city' => 'Houston',
                'state' => 'TX',
                'created_at' => '2024-10-18 06:37:05',
                'updated_at' => '2024-10-18 06:37:05',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}