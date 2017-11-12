<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class ModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get categories
        $airMover = Category::getByName('Air Mover');
        $dehumidifier = Category::getByName('Dehumidifier');
        $airscrubber = Category::getByName('Air Scrubber');

        $models = [
            [
                'name' => 'Dry Air Tempest',
                'category_id' => $airMover->id
            ],
            [
                'name' => 'Dri-Eaz LGR 7000XLi',
                'category_id' => $dehumidifier->id
            ],
            [
                'name' => 'Dri-Eaz F284 DefendAir',
                'category_id' => $airscrubber->id
            ],
        ];

        DB::table('equipment_models')->insert($models);
    }
}
