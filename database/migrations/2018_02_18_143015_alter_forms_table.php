<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('standard_forms', function($table) {
            $table->dropColumn('signature');
        });
        Schema::table('default_forms_data', function($table) {
            $table->dropColumn('signature');
        });

        Schema::table('standard_forms', function($table) {
            $table->text('insured_signature')->nullable()->default(null)->after('footer_text');
            $table->text('company_signature')->nullable()->default(null)->after('insured_signature');
        });
        Schema::table('default_forms_data', function($table) {
            $table->text('insured_signature')->nullable()->default(null)->after('footer_text');
            $table->text('company_signature')->nullable()->default(null)->after('insured_signature');
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
        Schema::table('standard_forms', function($table) {
            $table->dropColumn('insured_signature');
            $table->dropColumn('company_signature');
            $table->text('signature')->nullable()->default(null)->after('footer_text');
        });
        Schema::table('default_forms_data', function($table) {
            $table->dropColumn('insured_signature');
            $table->dropColumn('company_signature');
            $table->text('signature')->nullable()->default(null)->after('footer_text');
        });
    }
}
