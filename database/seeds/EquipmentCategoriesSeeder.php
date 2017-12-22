<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $categories = [
            [
                'id' => 1,
                'name' => 'Air Mover',
                'prefix' => 'AM',
                'company_id' => 1
            ],
            [
                'id' => 2,
                'name' => 'Air Mover',
                'prefix' => 'AM',
                'company_id' => 2
            ],
            [
                'id' => 3,
                'name' => 'Dehumidifier',
                'prefix' => 'D',
                'company_id' => 2
            ],
            [
                'id' => 4,
                'name' => 'Air Scrubber',
                'prefix' => 'AS',
                'company_id' => 2
            ],
        ];

        DB::table('equipment_categories')->truncate();
        DB::table('equipment_categories')->insert($categories);

        Schema::enableForeignKeyConstraints();
    }
}
