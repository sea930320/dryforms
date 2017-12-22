<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablesAddCompaniesKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('permission_users');
        Schema::dropIfExists('permission_roles');

        Schema::table('equipment_categories', function ($table) {
            $table->integer('company_id')->unsigned()->nullable()->default(null)->after('updated_at');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });

        Schema::table('equipment_models', function ($table) {
            $table->integer('company_id')->unsigned()->nullable()->default(null)->after('updated_at');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });

        Schema::table('equipments', function ($table) {
            $table->integer('company_id')->unsigned()->nullable()->default(null)->after('updated_at');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });

        Schema::table('teams', function ($table) {
            $table->integer('company_id')->unsigned()->nullable()->default(null)->after('updated_at');
            $table->dropColumn('description');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // no way out
    }
}
