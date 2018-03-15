<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('projects', function(Blueprint $table) {
            $table->dropForeign('projects_owner_id_foreign');
            $table->dropColumn('owner_id');
        });        
        Schema::enableForeignKeyConstraints();

        Schema::table('projects', function (Blueprint $table) {
            $table->string('owner_name')->nullable()->default(null);
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
        Schema::table('projects', function(Blueprint $table) {
            $table->dropColumn('owner_name');
            
        });        
        Schema::enableForeignKeyConstraints();

        Schema::table('projects', function (Blueprint $table) {
            $table->integer('owner_id')->unsigned();
            $table->foreign('owner_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
}
