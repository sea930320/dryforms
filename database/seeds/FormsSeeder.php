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
            'company_id' => -1,
            'name' => 'Call Report'
        ],
        [
            'id' => 2,
            'company_id' => -1,
            'name' => 'Project Scope'
        ],
        [
            'id' => 3,
            'company_id' => -1,
            'name' => 'Daily Log'
        ],
        [
            'id' => 4,
            'company_id' => -1,
            'name' => 'Work Authorization'
        ],
        [
            'id' => 5,
            'company_id' => -1,
            'name' => 'Anti-Microbial'
        ],
        [
            'id' => 6,
            'company_id' => -1,
            'name' => 'Customer Responsibility'
        ],
        [
            'id' => 7,
            'company_id' => -1,
            'name' => 'Moisture Map'
        ],
        [
            'id' => 8,
            'company_id' => -1,
            'name' => 'Psychometric Report'
        ],
        [
            'id' => 9,
            'company_id' => -1,
            'name' => 'Release from Liability'
        ],
        [
            'id' => 10,
            'company_id' => -1,
            'name' => 'Work Stoppage'
        ],
        [
            'id' => 11,
            'company_id' => -1,
            'name' => 'Certificate of Completion'
        ],
        [
            'id' => 12,
            'company_id' => -1,
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
