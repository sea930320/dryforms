<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::where('name', 'Admin')->first();

        $companies = [
            [
                'user_id' => $user ? $user->id : null,
                'name' => 'Company 1',
                'logo' => null,
                'street' => 'Street 1',
                'city' => 'City 1',
                'state' => 'State 1',
                'zip' => '12345',
                'phone' => '12333322211',
                'email' => 'company@email.com',
                'cloud_link' => null
            ]
        ];

        DB::table('companies')->insert($companies);
    }
}
