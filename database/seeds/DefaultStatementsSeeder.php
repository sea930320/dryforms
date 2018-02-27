<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultStatementsSeeder extends Seeder
{
    /**
     * @var array
     */
    private $statements = [
        [
            'form_id' => 4,
            'statement' => '<h1>some content</h1>',
            'title' => 'Enter form body text'
        ],
        [
            'form_id' => 5,
            'statement' => '<h1>accept content</h1>',
            'title' => 'Enter accept text'
        ],
        [
            'form_id' => 5,
            'statement' => '<h1>decline content</h1>',
            'title' => 'Enter decline text'
        ],
        [
            'form_id' => 6,
            'statement' => '<h1>some content</h1>',
            'title' => 'Enter form body text'
        ],
        [
            'form_id' => 9,
            'statement' => '<h1>some content</h1>',
            'title' => 'Enter form body text'
        ],
        [
            'form_id' => 10,
            'statement' => '<h1>some content</h1>',
            'title' => 'Enter form body text'
        ],
        [
            'form_id' => 11,
            'statement' => '<h1>some content</h1>',
            'title' => 'Enter form body text'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('default_statements')->truncate();
        DB::table('default_statements')->insert($this->statements);
    }
}