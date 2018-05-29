<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectPsychometricDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_psychometric_days', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('area_id')->unsigned()->nullable()->default(null);
            $table->integer('containment_id')->unsigned()->nullable()->default(null);
            $table->dateTime('current_time')->default(null);
            $table->string('outside')->nullable()->default(null);
            $table->string('unaffected')->nullable()->default(null);
            $table->string('affected')->nullable()->default(null);
            $table->string('dehumidifier')->nullable()->default(null);
            $table->string('hvac')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_psychometric_days');
    }
}
