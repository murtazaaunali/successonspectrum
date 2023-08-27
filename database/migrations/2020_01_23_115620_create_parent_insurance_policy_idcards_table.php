<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentInsurancePolicyIdcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_insurance_policy_idcards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('client_insurance_id');
            $table->text('client_insurancecompanyidcard')->nullable();
            $table->string('client_insurancecompanyidcard_name')->nullable();
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
        Schema::dropIfExists('parent_insurance_policy_idcards');
    }
}
