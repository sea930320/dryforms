<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Air Mover',
                'prefix' => 'AM'
            ],
            [
                'name' => 'Dehumidifier',
                'prefix' => 'D'
            ],
            [
                'name' => 'Air Scrubber',
                'prefix' => 'AS'
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
