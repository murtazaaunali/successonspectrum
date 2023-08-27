<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFemployeesAbaExperienceReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('femployees_aba_experience_reference', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('admin_employee_id');
            $table->date('employment_startingdate')->nullable();
			$table->date('employment_endingdate')->nullable();
			$table->string('companyname',191);
			$table->string('positionheld',191);
            $table->string('reasonforleaving',191);
			$table->string('managersname',191);
            $table->string('phone',32);
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
        Schema::dropIfExists('femployees_aba_experience_reference');
    }
}
