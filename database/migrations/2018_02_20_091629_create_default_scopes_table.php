<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultScopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_scopes', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('selected')->default(false);
            $table->string('service')->nullable()->default(null);
            $table->string('units')->nullable()->default(null);
            $table->boolean('is_header')->default(false);
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
        Schema::dropIfExists('default_scopes');
    }
}
