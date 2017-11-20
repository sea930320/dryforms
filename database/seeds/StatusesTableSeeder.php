<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('equipment_statuses')->truncate();

        $statuses = [
            [
                'name' => 'Available'
            ],
            [
                'name' => 'O.O.C.'
            ],
            [
                'name' => 'Set'
            ],
            [
                'name' => 'Loan'
            ],
        ];

        DB::table('equipment_statuses')->insert($statuses);

        Schema::enableForeignKeyConstraints();
    }
}
