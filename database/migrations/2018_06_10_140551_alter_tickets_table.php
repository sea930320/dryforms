<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
        Schema::enableForeignKeyConstraints();

        Schema::table('tickets', function(Blueprint $table){
            $table->integer('category_id')->unsigned()->nullable()->default(null);
            $table->foreign('category_id')
                ->references('id')
                ->on('ticket_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('tickets', function(Blueprint $table) {
            $table->dropForeign('tickets_category_id_foreign');            
        });
        Schema::enableForeignKeyConstraints();
    }
}
