<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStandardFormsTableAddNewColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('standard_forms', function($table) {
            $table->boolean('additional_notes_show')->default(false)->after('title');
            $table->boolean('footer_text_show')->default(false)->after('additional_notes_show');
            $table->text('footer_text')->nullable()->after('footer_text_show');
            $table->boolean('signature')->default(false)->after('footer_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('standard_forms', function($table) {
            $table->dropColumn('additional_notes_show');
            $table->dropColumn('footer_text_show');
            $table->dropColumn('footer_text');
            $table->dropColumn('signature');
        });
    }
}
