<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'Super admin dashboard'
            ],
            [
                'name' => 'Billing'
            ],
            [
                'name' => 'Add equipment'
            ],
            [
                'name' => 'Delete equipment'
            ]
        ];

        \Illuminate\Support\Facades\DB::table('permissions')->insert($permissions);
    }
}
