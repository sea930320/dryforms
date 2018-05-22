<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectMoistureDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_moisture_days', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('area_setting_id')->unsigned()->nullable()->default(null);
            $table->integer('amount')->unsigned();
            $table->dateTime('current_time')->default(null);
            $table->timestamps();
            $table->foreign('area_setting_id')
                ->references('id')
                ->on('project_moisture_settings')
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
        Schema::dropIfExists('project_moisture_days');
    }
}
