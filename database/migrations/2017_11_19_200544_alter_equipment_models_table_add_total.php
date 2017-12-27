<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEquipmentModelsTableAddTotal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment_models', function ($table) {
            $table->dropColumn('equipments_count');
            $table->integer('total')->after('name')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment_models', function ($table) {
            $table->dropColumn('total');
            $table->integer('equipments_count')->after('name')->unsigned()->default(0);
        });
    }
}
