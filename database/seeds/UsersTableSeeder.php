<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // careate super admin
        $superAdmin = \App\Models\User::create([
            'first_name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('qwerty123')
        ]);

        // add role
        $superAdmin->assignRole('Super Admin');

        // add permissions
        $superAdmin->givePermissionTo('Super admin dashboard');
        $superAdmin->givePermissionTo('Billing');
        $superAdmin->givePermissionTo('Add equipment');
        $superAdmin->givePermissionTo('Delete equipment');

        // create admin
        $admin = \App\Models\User::create([
            'first_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('qwerty123')
        ]);

        // add role
        $admin->assignRole('Admin');



        // add permissionsp\
        $admin->givePermissionTo('Billing');
        $admin->givePermissionTo('Add equipment');
        $admin->givePermissionTo('Delete equipment');

        // create user
        $user = \App\Models\User::create([
            'first_name' => 'User',
            'email' => 'user@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('qwerty123')
        ]);

        // add role
        $user->assignRole('User');
    }
}
