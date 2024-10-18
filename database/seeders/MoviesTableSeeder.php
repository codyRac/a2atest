<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MoviesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('movies')->delete();
        
        \DB::table('movies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Dumb and Dumber',
                'release_date' => '2019-11-08 12:18:30',
                'rating' => 'PG-13',
                'created_at' => '2024-10-18 06:32:58',
                'updated_at' => '2024-10-18 06:32:58',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Forrest Gump',
                'release_date' => '2015-01-27 02:47:58',
                'rating' => 'PG',
                'created_at' => '2024-10-18 06:32:58',
                'updated_at' => '2024-10-18 06:32:58',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Speed',
                'release_date' => '1998-11-23 20:28:06',
                'rating' => 'R',
                'created_at' => '2024-10-18 06:32:58',
                'updated_at' => '2024-10-18 06:32:58',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}