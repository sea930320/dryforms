<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormsSeeder extends Seeder
{
    /**
     * @var array
     */
    private $forms = [
        [
            'id' => 1,
            'name' => 'Call Report'
        ],
        [
            'id' => 2,
            'name' => 'Project Scope'
        ],
        [
            'id' => 3,
            'name' => 'Daily Log'
        ],
        [
            'id' => 4,
            'name' => 'Work Authorization'
        ],
        [
            'id' => 5,
            'name' => 'Anti-Microbial'
        ],
        [
            'id' => 6,
            'name' => 'Customer Responsibility'
        ],
        [
            'id' => 7,
            'name' => 'Moisture Map'
        ],
        [
            'id' => 8,
            'name' => 'Psychometric Report'
        ],
        [
            'id' => 9,
            'name' => 'Release from Liability'
        ],
        [
            'id' => 10,
            'name' => 'Work Stoppage'
        ],
        [
            'id' => 11,
            'name' => 'Certificate of Completion'
        ],
        [
            'id' => 12,
            'name' => 'Affected Areas'
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('forms')->truncate();
        DB::table('forms')->insert($this->forms);
        Schema::enableForeignKeyConstraints();
    }
}
