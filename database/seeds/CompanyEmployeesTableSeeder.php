<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyEmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee1 = \App\Models\User::create([
            'name' => 'Employee 1',
            'email' => 'sincityprivate.employee1@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Z:LE7x)K')
        ]);
        $employee1->assignRole('Admin');
        $employee1->givePermissionTo('Billing');
        $employee1->givePermissionTo('Add equipment');
        $employee1->givePermissionTo('Delete equipment');

        $employee2 = \App\Models\User::create([
            'name' => 'Employee 2',
            'email' => 'sincityprivate.employee2@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Z:LE7x)K')
        ]);
        $employee2->assignRole('User');

        $employee3 = \App\Models\User::create([
            'name' => 'Employee 3',
            'email' => 'sincityprivate.employee3@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Z:LE7x)K')
        ]);
        $employee3->assignRole('User');


        $active = \App\Models\EmployeeStatus::where('name', 'Active')->first();
        $suspended = \App\Models\EmployeeStatus::where('name', 'Suspended')->first();

        $company = \App\Models\Company::where('name', 'Company 1')->first();


        $employees = [
            [
                'user_id' => $employee1->id,
                'company_id' => $company->id,
                'status_id' => $active->id
            ],
            [
                'user_id' => $employee2->id,
                'company_id' => $company->id,
                'status_id' => $suspended->id
            ],
            [
                'user_id' => $employee3->id,
                'company_id' => $company->id,
                'status_id' => $suspended->id
            ]
        ];

        DB::table('company_employees')->insert($employees);
    }
}
