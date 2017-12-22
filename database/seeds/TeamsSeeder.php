<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TeamsSeeder extends Seeder
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
                'name' => 'Team 1',
                'company_id' => 2
            ],
            [
                'name' => 'Team 11',
                'company_id' => 1
            ],
            [
                'name' => 'Team 2',
                'company_id' => 2
            ],
            [
                'name' => 'Team 3',
                'company_id' => 2
            ],
        ];

        Schema::disableForeignKeyConstraints();

        DB::table('teams')->truncate();
        DB::table('teams')->insert($teams);

        Schema::enableForeignKeyConstraints();
    }
}
