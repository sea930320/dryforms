<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::disableForeignKeyConstraints();
        Schema::table('projects', function(Blueprint $table){
            $table->dropColumn('status');
        });        
        Schema::enableForeignKeyConstraints();

        Schema::table('projects', function(Blueprint $table){
            $table->integer('status')->unsigned()->nullable()->default(null);
            $table->foreign('status')
                ->references('id')
                ->on('project_status')
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
        Schema::table('projects', function(Blueprint $table){
            $table->dropForeign('projects_status_foreign');
            $table->dropColumn('status');
        });        
        Schema::enableForeignKeyConstraints();

        Schema::table('projects', function(Blueprint $table){
            $table->enum('status', ['New', 'In Progress', 'Completed', 'Deleted']);
        });

        Schema::dropIfExists('project_status');
    }
}
