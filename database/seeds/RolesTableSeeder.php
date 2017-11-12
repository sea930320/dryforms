<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Super Admin'
            ],
            [
                'name' => 'Admin'
            ],
            [
                'name' => 'User'
            ]
        ];

        \Illuminate\Support\Facades\DB::table('roles')->insert($roles);
    }
}
