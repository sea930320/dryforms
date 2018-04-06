<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectScopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_scopes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->nullable()->default(null);
            $table->integer('company_id')->unsigned()->nullable()->default(null);
            $table->integer('project_area_id')->unsigned()->nullable()->default(null);
            $table->boolean('standard_scope_edited')->default(false);
            $table->boolean('selected')->default(false);
            $table->string('service')->nullable()->default(null);
            $table->boolean('is_header')->default(false);
            $table->string('qty')->nullable()->default(null);
            $table->integer('uom')->unsigned()->nullable()->default(null);
            $table->integer('page')->unsigned();
            $table->integer('no')->unsigned();
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade');

            $table->foreign('project_area_id')
                ->references('id')
                ->on('project_areas')
                ->onDelete('cascade');

            $table->foreign('uom')
                ->references('id')
                ->on('units_of_measure')
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
        Schema::dropIfExists('project_scopes');
    }
}
