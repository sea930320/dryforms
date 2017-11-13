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
        $airMover =  DB::table('equipment_categories')->where('name', 'Air Mover')->select(['id'])->first();
        $dehumidifier = DB::table('equipment_categories')->where('name', 'Dehumidifier')->select(['id'])->first();
        $airscrubber = DB::table('equipment_categories')->where('name', 'Air Scrubber')->select(['id'])->first();

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
