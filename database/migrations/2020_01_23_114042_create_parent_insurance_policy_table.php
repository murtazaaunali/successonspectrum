<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentInsurancePolicyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_insurance_policy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('client_id');
            $table->string('client_insurancename')->nullable();
            $table->string('client_insurancecompanyname', 255)->nullable();
			$table->string('client_insurancephone_number', 255)->nullable();
            $table->string('client_memberid', 255)->nullable();
            $table->string('client_groupid', 255)->nullable();
            $table->string('client_policyholdersname', 255)->nullable();
            $table->date('client_policyholdersdateofbirth')->nullable();
            $table->string('client_subscribername')->nullable();
            $table->date('client_subscriberdateofbirth')->nullable();
            $table->date('client_benefiteffectivedate')->nullable();
            $table->date('client_benefitexpirationdate')->nullable();
            $table->string('client_benefitcopay',32)->nullable();
            $table->string('client_benefitoopm')->nullable();
            $table->string('client_benefitannualbenefits', 32)->nullable();
            $table->text('client_benefitclaimaddress')->nullable();
            $table->string('client_benefitinsuranceemployee')->nullable();
            $table->string('client_benefitreferencenumber')->nullable();
            $table->date('client_benefitdateverified')->nullable();
            $table->tinyInteger('client_insurance_primary')->nullable();
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
        Schema::dropIfExists('parent_insurance_policy');
    }
}
