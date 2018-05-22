<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectMoistureSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_moisture_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_area_id')->unsigned()->nullable()->default(null);
            $table->integer('structure_id')->unsigned()->nullable()->default(null);
            $table->integer('matarial_id')->unsigned()->nullable()->default(null);
            $table->timestamps();
            $table->foreign('project_area_id')
                ->references('id')
                ->on('project_areas')
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
        Schema::dropIfExists('project_moisture_settings');
    }
}
