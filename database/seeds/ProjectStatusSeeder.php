<?php

use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
	/**
     * @var array
     */
    private $statuses = [
        [
            'id' => 1,
            'name' => 'New'
        ],
        [
            'id' => 2,
            'name' => 'In Progress'
        ],
        [
            'id' => 3,
            'name' => 'Completed'
        ],
        [
            'id' => 4,
            'name' => 'Deleted'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('project_status')->truncate();
        DB::table('project_status')->insert($this->statuses);
        Schema::enableForeignKeyConstraints();
    }
}
