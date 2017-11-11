<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

        DB::table('statuses')->insert($statuses);
    }
}
