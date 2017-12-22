<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class EquipmentModelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $models = [
            [
                'id' => 1,
                'name' => 'Dry Air Tempest',
                'prefix' => 'AM',
                'category_id' => 1,
                'company_id' => 1
            ],
            [
                'id' => 2,
                'name' => 'Dry Air Tempest',
                'prefix' => 'AM',
                'category_id' => 1,
                'company_id' => 2
            ],
            [
                'id' => 3,
                'name' => 'Dri-Eaz LGR 7000XLi',
                'prefix' => 'D',
                'category_id' => 1,
                'company_id' => 2
            ],
            [
                'id' => 4,
                'name' => 'Dri-Eaz F284 DefendAir',
                'prefix' => 'AS',
                'category_id' => 4,
                'company_id' => 1
            ],
            [
                'id' => 5,
                'name' => 'Dri-Eaz F284 DefendAir 2',
                'prefix' => 'AS',
                'category_id' => 3,
                'company_id' => 2
            ],
            [
                'id' => 6,
                'name' => 'Dri-Eaz F284 DefendAir 3',
                'prefix' => 'AS',
                'category_id' => 3,
                'company_id' => 2
            ],
        ];

        DB::table('equipment_models')->truncate();
        DB::table('equipment_models')->insert($models);

        Schema::enableForeignKeyConstraints();
    }
}
