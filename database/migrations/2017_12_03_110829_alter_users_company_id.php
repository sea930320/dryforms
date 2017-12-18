<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersCompanyId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('users', function ($table) {
            $table->dropForeign('users_company_id_foreign');
            $table->dropColumn('company_id');
        });

        Schema::table('users', function ($table) {
            $table->integer('company_id')->unsigned()->nullable()->default(null)->after('updated_at');

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
        Schema::disableForeignKeyConstraints();

        Schema::table('users', function ($table) {
            $table->dropColumn('company_id');
        });

        Schema::table('users', function ($table) {
            $table->integer('company_id')->unsigned()->after('updated_at');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }
}
