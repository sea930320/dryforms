<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDefaultScopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('default_scopes', function (Blueprint $table) {
            $table->dropColumn('units');
        });
        Schema::enableForeignKeyConstraints();
        
        Schema::table('default_scopes', function (Blueprint $table) {
            $table->string('qty')->nullable()->default(null);
            $table->integer('uom')->unsigned()->nullable()->default(null);
            $table->integer('page')->unsigned();
            $table->integer('no')->unsigned();
            
            $table->foreign('uom')
                ->references('id')
                ->on('units_of_measure')
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
        //
    }
}
