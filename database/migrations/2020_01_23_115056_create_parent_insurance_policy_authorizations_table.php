<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentInsurancePolicyAuthorizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_insurance_policy_authorizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('client_insurance_id');
            $table->date('client_authorizationsstartdate');
            $table->date('client_authorizationseenddate');
            $table->string('client_authorizationsaba');
            $table->string('client_authorizationssupervision');
            $table->date('client_authorizationsparenttraining');
            $table->date('client_authorizationsreassessment');
            $table->tinyInteger('archive')->default(0);
            $table->tinyInteger('isdelete')->default(0);
            $table->tinyInteger('isactive')->default(0);
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
        Schema::dropIfExists('parent_insurance_policy_authorizations');
    }
}
