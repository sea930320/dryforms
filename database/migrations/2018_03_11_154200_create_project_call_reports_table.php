<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectCallReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_call_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('project_id')->unsigned();

            $table->string('contact_name')->nullable()->default(null);
            $table->string('contact_phone')->nullable()->default(null);
            $table->string('site_phone')->nullable()->default(null);
            $table->date('date_contacted')->nullable()->default(null);
            $table->time('time_contacted')->nullable()->default(null);
            $table->date('date_loss')->nullable()->default(null);
            $table->string('point_loss')->nullable()->default(null);
            $table->date('date_completed')->nullable()->default(null);
            $table->string('category')->nullable()->default(null);
            $table->string('class')->nullable()->default(null);
            $table->string('job_address')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('state')->nullable()->default(null);
            $table->string('zip_code')->nullable()->default(null);
            $table->string('cross_streets')->nullable()->default(null);
            $table->string('apartment_name')->nullable()->default(null);
            $table->string('building_no')->nullable()->default(null);
            $table->string('apartment_no')->nullable()->default(null);
            $table->string('gate_code')->nullable()->default(null);
            $table->integer('assigned_to')->unsigned()->nullable()->default(null);
            $table->boolean('is_residential')->default(false);
            $table->boolean('is_commercial')->default(false);
            $table->boolean('is_insured')->default(false);
            $table->boolean('is_tenant')->default(false);
            $table->boolean('is_water')->default(false);
            $table->boolean('is_sewage')->default(false);
            $table->boolean('is_mold')->default(false);
            $table->boolean('is_fire')->default(false);

            $table->string('insured_name')->nullable()->default(null);
            $table->string('billing_address')->nullable()->default(null);
            $table->string('insured_city')->nullable()->default(null);
            $table->string('insured_state')->nullable()->default(null);
            $table->string('insured_zip_code')->nullable()->default(null);
            $table->string('insured_home_phone')->nullable()->default(null);
            $table->string('insured_cell_phone')->nullable()->default(null);
            $table->string('insured_work_phone')->nullable()->default(null);
            $table->string('insured_email')->nullable()->default(null);
            $table->string('insured_fax')->nullable()->default(null);

            $table->string('insurance_claim_no')->nullable()->default(null);
            $table->string('insurance_company')->nullable()->default(null);
            $table->string('insurance_policy_no')->nullable()->default(null);
            $table->string('insurance_deductible')->nullable()->default(null);
            $table->string('insurance_adjuster')->nullable()->default(null);
            $table->string('insurance_address')->nullable()->default(null);
            $table->string('insurance_city')->nullable()->default(null);
            $table->string('insurance_state')->nullable()->default(null);
            $table->string('insurance_zip_code')->nullable()->default(null);
            $table->string('insurance_work_phone')->nullable()->default(null);
            $table->string('insurance_cell_phone')->nullable()->default(null);
            $table->string('insurance_email')->nullable()->default(null);
            $table->string('insurance_fax')->nullable()->default(null);

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade');

            $table->foreign('assigned_to')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');

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
        Schema::dropIfExists('project_call_reports');
    }
}
