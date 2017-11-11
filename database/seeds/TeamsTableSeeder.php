<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            [
                'name' => 'Team 1'
            ],
            [
                'name' => 'Team 2'
            ],
            [
                'name' => 'Team 3'
            ],
        ];

        DB::table('teams')->insert($teams);
    }
}
