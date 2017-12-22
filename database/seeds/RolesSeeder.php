<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RolesSeeder extends Seeder
{
    /**
     * @var array
     */
    private $roles = [
        [
            'id' => 1,
            'name' => 'Super Admin'
        ],
        [
            'id' => 2,
            'name' => 'Admin'
        ],
        [
            'id' => 3,
            'name' => 'User'
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

        DB::table('roles')->truncate();
        DB::table('roles')->insert($this->roles);

        Schema::enableForeignKeyConstraints();
    }
}
