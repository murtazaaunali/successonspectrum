<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmploymentFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_form', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('franchise_id');
            $table->string('personal_name',191)->nullable();
			$table->date('personal_dob')->nullable();
            $table->string('personal_ss',191)->nullable();
			$table->string('personal_phone',32)->nullable();
            $table->string('email',255)->nullable();
            $table->string('personal_email',255)->nullable();
            $table->string('personal_city',191)->nullable();
            $table->string('personal_state',191)->nullable();
            $table->string('personal_zipcode',191)->nullable();
			//$table->enum('crew_type',['Oceaner','Voyager'])->nullable();
			$table->enum('crew_type',['Ocean','Voyager','Sailor'])->nullable();
            $table->text('personal_address')->nullable();
			$table->string('personal_picture',255)->nullable();
			$table->enum('personal_status',['Active','Terminated','Applicant','Vacation'])->default('Applicant');
            
            //CAREER OPTIONS
            $table->text('career_desired_position')->nullable();
            $table->string('career_desired_schedule',32)->nullable();
            $table->text('career_availability')->nullable();
			$table->decimal('career_desired_pay',15,2)->nullable();
			$table->decimal('career_starting_pay',15,2)->nullable();
			$table->decimal('career_current_pay',15,2)->nullable();
			$table->enum('career_insurance_plan',['Yes', 'No'])->nullable();
            $table->enum('career_retirement_plan',['Yes', 'No'])->nullable();
			$table->integer('career_paid_vacation')->nullable();
            $table->integer('career_paid_holiday')->nullable();
            $table->integer('career_allowed_sick_leaves')->nullable();
            $table->date('career_earliest_startdate')->nullable();
            $table->string('career_bacb',10)->nullable();
            $table->date('bacb_regist_date')->nullable();
            $table->string('career_cpr_certified',10)->nullable();
            $table->date('cpr_regist_date')->nullable();
            $table->text('career_highest_degree')->nullable();
            $table->text('career_desired_location')->nullable();
            $table->date('career_probation_completion_date')->nullable();
			
            //WORK ELIGIBILITY
            $table->string('work_underage',10)->nullable();
            $table->string('work_authorised',10)->nullable();
            $table->string('work_capable',10)->nullable();
            $table->text('work_nocapable')->nullable();
            $table->string('work_liftlbs',10)->nullable();
            
            //ABA EXPERIENCE AND REFERENCES
            $table->date('aba_employment_startingdate')->nullable();
            $table->date('aba_employment_endingdate')->nullable();
            $table->string('aba_companyname',255)->nullable();
            $table->string('aba_positionheld',255)->nullable();
            $table->string('aba_reasonforleaving',255)->nullable();
            $table->string('aba_managersname',255)->nullable();
            $table->string('aba_phone',255)->nullable();
            $table->date('aba_employment_startingdate2')->nullable();
            $table->date('aba_employment_endingdate2')->nullable();
            $table->string('aba_companyname2',255)->nullable();
            $table->string('aba_positionheld2',255)->nullable();
            $table->string('aba_reasonforleaving2',255)->nullable();
            $table->string('aba_managersname2',255)->nullable();
            $table->string('aba_phone2',255)->nullable();
            $table->date('aba_employment_startingdate3')->nullable();
            $table->date('aba_employment_endingdate3')->nullable();
            $table->string('aba_companyname3',255)->nullable();
            $table->string('aba_positionheld3',255)->nullable();
            $table->string('aba_reasonforleaving3',255)->nullable();
            $table->string('aba_managersname3',255)->nullable();
            $table->string('aba_phone3',255)->nullable();

            //CAREFULLY SIGNING APPLICATION
            $table->string('careully_applicantpname',255)->nullable();
            $table->date('careully_date')->nullable();
            $table->string('careully_signature',255)->nullable();
			
			$table->string('password',191)->nullable();
			$table->date('upcomming_performance')->nullable();
			$table->text('assigned_position')->nullable();
			$table->text('pdf')->nullable();
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
        Schema::dropIfExists('employment_form');
    }
}
