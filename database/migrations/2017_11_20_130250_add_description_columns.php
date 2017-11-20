<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment_categories', function ($table) {
            $table->string('description')->after('prefix')->nullable()->default(null);
        });

        Schema::table('equipment_models', function ($table) {
            $table->string('description')->after('name')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment_categories', function ($table) {
            $table->dropColumn('description');
        });

        Schema::table('equipment_models', function ($table) {
            $table->dropColumn('description');
        });
    }
}
