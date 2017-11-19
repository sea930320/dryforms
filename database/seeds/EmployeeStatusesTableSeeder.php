<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeStatusesTableSeeder extends Seeder
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
                'name' => 'Active',
            ],
            [
                'name' => 'Suspended'
            ]
        ];

        DB::table('employees_statuses')->insert($statuses);
    }
}
