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
            'form_id' => 2,
            'statement' => "<table style=\"width: 100%;\"><tbody><tr><td style=\"width: 16.6667%; text-align: center; background-color: rgb(204, 204, 204);\"><div>X</div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\">Service</div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\">Units/Hr</div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\">X</div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\">Service</div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\">Units/Hr</div></td></tr><tr><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td></tr><tr><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td></tr><tr><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td></tr><tr><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td></tr><tr><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td></tr><tr><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td></tr><tr><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td></tr><tr><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td></tr><tr><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%; background-color: rgb(204, 204, 204);\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td><td style=\"width: 16.6667%;\"><div data-empty=\"true\" style=\"text-align: center;\"><br></div></td></tr></tbody></table>",
            'title' => ''
        ],
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