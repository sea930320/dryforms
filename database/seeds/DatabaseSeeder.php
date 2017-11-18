<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(EmployeeStatusesTableSeeder::class);
        $this->call(CompanyEmployeesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(ModelsTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
    }
}
