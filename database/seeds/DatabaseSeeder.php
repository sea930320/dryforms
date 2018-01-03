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
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(CompaniesSeeder::class);
        $this->call(EquipmentCategoriesSeeder::class);
        $this->call(EquipmentModelsSeeder::class);
        $this->call(StatusesSeeder::class);
        $this->call(EquipmentsSeeder::class);
        $this->call(TeamsSeeder::class);
        $this->call(FormsSeeder::class);
        $this->call(AreasSeeder::class);
    }
}
