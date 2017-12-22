<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $companies = [
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Super Admin Company',
                'logo' => null,
                'street' => 'Street 1',
                'city' => 'City 1',
                'state' => 'State 1',
                'zip' => '12345',
                'phone' => '12333322211',
                'email' => 'company@email.com',
                'cloud_link' => null
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'name' => 'Dry Company',
                'logo' => null,
                'street' => 'Street 2',
                'city' => 'City 3',
                'state' => 'State 4',
                'zip' => '12345',
                'phone' => '12333322211',
                'email' => 'dry.company@email.com',
                'cloud_link' => null
            ]
        ];

        DB::table('companies')->truncate();
        DB::table('companies')->insert($companies);

        Schema::enableForeignKeyConstraints();
    }
}
