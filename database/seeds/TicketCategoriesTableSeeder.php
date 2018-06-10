<?php

use Illuminate\Database\Seeder;

class TicketCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'category_1'
            ],
            [
                'name' => 'category_2'
            ]
        ];

        Schema::disableForeignKeyConstraints();

        DB::table('ticket_categories')->truncate();
        DB::table('ticket_categories')->insert($categories);

        Schema::enableForeignKeyConstraints();
    }
}
