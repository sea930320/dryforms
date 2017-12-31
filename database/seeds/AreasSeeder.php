<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            [
                'title' => 'Area 1',
                'type' => 'company',
                'company_id' => 2
            ],
            [
                'title' => 'Area 2',
                'type' => 'company',
                'company_id' => 2
            ],
            [
                'title' => 'Area 3',
                'type' => 'system',
                'company_id' => null
            ],
            [
                'title' => 'Area 4',
                'type' => 'company',
                'company_id' => 3
            ],
            [
                'title' => 'Area 5',
                'type' => 'company',
                'company_id' => 2
            ],
            [
                'title' => 'Area 6',
                'type' => 'system',
                'company_id' => null
            ],

        ];

        Schema::disableForeignKeyConstraints();

        DB::table('areas')->truncate();
        DB::table('areas')->insert($areas);

        Schema::enableForeignKeyConstraints();
    }
}
