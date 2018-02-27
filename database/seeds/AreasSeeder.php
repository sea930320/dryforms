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
                'company_id' => 2
            ],
            [
                'title' => 'Area 2',
                'company_id' => 2
            ],
            [
                'title' => 'Area 3',
                'company_id' => 1
            ],
            [
                'title' => 'Area 4',
                'company_id' => 3
            ],
            [
                'title' => 'Area 5',
                'company_id' => 2
            ],
            [
                'title' => 'Area 6',
                'company_id' => 1
            ],

        ];

        Schema::disableForeignKeyConstraints();

        DB::table('areas')->truncate();
        DB::table('areas')->insert($areas);

        Schema::enableForeignKeyConstraints();
    }
}
