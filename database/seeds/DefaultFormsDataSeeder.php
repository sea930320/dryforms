<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultFormsDataSeeder extends Seeder
{
    /**
     * @var array
     */
    private $forms = [
        [
            'form_id' => 1,
            'name' => 'Call Report',
            'title' => 'Call Report',
        ],
        [
            'form_id' => 2,
            'name' => 'Project Scope',
            'title' => 'Project Scope',
        ],
        [
            'form_id' => 3,
            'name' => 'Daily Log',
            'title' => 'Daily Log',
        ],
        [
            'form_id' => 4,
            'name' => 'Work Authorization',
            'title' => 'Work Authorization',
        ],
        [
            'form_id' => 5,
            'name' => 'Anti-Microbial',
            'title' => 'Anti-Microbial',
        ],
        [
            'form_id' => 6,
            'name' => 'Customer Responsibility',
            'title' => 'Customer Responsibility',
        ],
        [
            'form_id' => 7,
            'name' => 'Moisture Map',
            'title' => 'Moisture Map',
        ],
        [
            'form_id' => 8,
            'name' => 'Psychometric Report',
            'title' => 'Psychometric Report',
        ],
        [
            'form_id' => 9,
            'name' => 'Release from Liability',
            'title' => 'Release from Liability',
        ],
        [
            'form_id' => 10,
            'name' => 'Work Stoppage',
            'title' => 'Work Stoppage',
        ],
        [
            'form_id' => 11,
            'name' => 'Certificate of Completion',
            'title' => 'Certificate of Completion',
        ],
        [
            'form_id' => 12,
            'name' => 'Affected Areas',
            'title' => 'Affected Areas',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('default_forms_data')->truncate();
        DB::table('default_forms_data')->insert($this->forms);
    }
}