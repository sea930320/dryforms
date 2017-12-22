<?php

use Illuminate\Database\Seeder;

class EquipmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $equipment = [
            [
                'serial' => '123',
                'location' => 'somewhere',
                'company_id' => 1,
                'team_id' => 1,
                'model_id' => 1,
                'status_id' => 1
            ],
            [
                'serial' => '124',
                'location' => 'somewhere',
                'company_id' => 2,
                'team_id' => 3,
                'model_id' => 4,
                'status_id' => 2
            ],
            [
                'serial' => '125',
                'location' => 'somewhere',
                'company_id' => 2,
                'team_id' => 2,
                'model_id' => 2,
                'status_id' => 3
            ],
            [
                'serial' => '126',
                'location' => 'somewhere',
                'company_id' => 2,
                'team_id' => 3,
                'model_id' => 3,
                'status_id' => 1
            ],
            [
                'serial' => '127',
                'location' => 'somewhere',
                'company_id' => 2,
                'team_id' => 1,
                'model_id' => 1,
                'status_id' => 4
            ],
        ];

        Schema::disableForeignKeyConstraints();

        DB::table('equipments')->truncate();
        DB::table('equipments')->insert($equipment);

        Schema::enableForeignKeyConstraints();
    }
}
