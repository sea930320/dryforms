<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableAddNewColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('name');

            $table->string('first_name')->nullable()->after('email');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('address')->nullable()->after('last_name');
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->string('zip')->nullable()->after('state');
            $table->string('phone')->nullable()->after('zip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->string('first_name')->nullable()->after('id');

            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('zip');
            $table->dropColumn('phone');
        });
    }
}
