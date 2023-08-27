<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_form', function (Blueprint $table) {
            $table->bigIncrements('id');

            //$table->string('name');
            $table->integer('franchise_id');
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
			
            //Choose Location
            $table->string('chooselocation_interest',500)->nullable();
            $table->string('chooselocation_location',500)->nullable();
            
            //CLient Information
            $table->date('client_todaydate',32)->nullable();
            //$table->string('client_childfirstname',255)->nullable();
            //$table->string('client_childlastname',255)->nullable();
			$table->string('client_childfullname',255)->nullable();
            $table->string('client_childdateofbirth',255)->nullable();
            $table->string('client_custodialparent',50)->nullable();
            $table->string('client_momsname',255)->nullable();
            $table->string('client_momsemail',255)->nullable();
            $table->string('client_momscell',255)->nullable();
            $table->text('client_custodialparentsaddress')->nullable();
            $table->string('client_dadsname',255)->nullable();
            $table->string('client_dadsemail',255)->nullable();
            $table->string('client_dadscell',255)->nullable();
            $table->string('client_emergencycontactname',255)->nullable();
            $table->string('client_emergencycontactphone',255)->nullable();
            $table->string('client_insurancecompanyname',255)->nullable();
            $table->text('client_insurancecompanyidcard')->nullable();
            $table->string('client_memberid',255)->nullable();
            $table->string('client_groupid',255)->nullable();
            $table->string('client_policyholdersname',255)->nullable();
            $table->date('client_policyholdersdateofbirth',32)->nullable();
			$table->string('client_subscribername',191)->nullable();
			$table->date('client_subscriberdateofbirth')->nullable();
			$table->date('client_benefiteffectivedate')->nullable();
			$table->date('client_benefitexpirationdate')->nullable();
			$table->string('client_benefitcopay',32)->nullable();
			$table->string('client_benefitoopm',191)->nullable();
			$table->string('client_benefitannualbenefit',32)->nullable();
			$table->text('client_benefitclaimaddress')->nullable();
			$table->date('client_benefitdateverified')->nullable();	
			$table->string('client_benefitinsuranceemployee',191)->nullable();
			$table->string('client_benefitreferencenumber',191)->nullable();
			
			$table->date('client_authorizationsstartdate')->nullable();
			$table->date('client_authorizationseenddate')->nullable();
			$table->decimal('client_authorizationsaba',15,2)->nullable();
			$table->string('client_authorizationssupervision',191)->nullable();
			$table->date('client_authorizationsparenttraining')->nullable();
			$table->date('client_authorizationsreassessment')->nullable();	
			
            $table->text('client_ageandsymtoms')->nullable();
            $table->date('client_dateofautism')->nullable();
            $table->text('client_childdiagnostic_report')->nullable();
            $table->string('client_diagnosingdoctor',255)->nullable();
            $table->string('client_primarydiagnosis',255)->nullable();
            $table->string('client_secondarydiagnosis',255)->nullable();
            $table->text('client_childcurrentmedications')->nullable();
            $table->text('client_allergies')->nullable();

            $table->string('client_aba',32)->nullable()->default('No');
            $table->text('client_aba_facilities')->nullable();
            /*$table->string('client_start',32)->nullable();
            $table->string('client_end',32)->nullable();
            $table->string('client_hours',191)->nullable();*/
            
            $table->string('client_speechtherapy',32)->nullable()->default('No');
            $table->string('client_speechinstitution',191)->nullable();
            $table->string('client_speechhoursweek',191)->nullable();
            $table->string('client_occupationaltherapy',32)->nullable()->default('No');
            $table->string('client_occupationalinstitution',191)->nullable();
            $table->string('client_occupationalhoursweek',191)->nullable();
            $table->string('client_childattendschool',32)->nullable()->default('No');
            $table->string('client_schoolname',255)->nullable();
            $table->string('client_specialclass',255)->nullable();
            $table->text('client_childiep')->nullable();
			$table->string('client_medicalmedication',255)->nullable();
			$table->text('client_medicalabahistory')->nullable();
			$table->date('client_medicallastvisionexam')->nullable();
			$table->integer('client_medicalabahoursperweek')->nullable();
			$table->string('client_medicaltoolused',191)->nullable();
			$table->string('client_medicalphonenumber',191)->nullable();
			$table->string('client_medicalfaxnumber',191)->nullable();
			$table->text('client_medicaladdress')->nullable();
			//$table->integer('client_crew')->nullable();
			$table->enum('client_crew',['Ocean','Voyager','Sailor'])->nullable();
			$table->string('client_profilepicture',255)->nullable();
			$table->enum('client_status',['Active','Terminated','Applicant'])->nullable();
			$table->text('client_address')->nullable();
            
            //HIPAA Agreement Form
            $table->string('hipaa_childsname',191)->nullable();
            $table->string('hipaa_parentsname',191)->nullable();
            $table->text('hipaa_sospolicy')->nullable();
            $table->text('hipaa_insideourcenter')->nullable();
            $table->text('hipaa_whenclients')->nullable();
            $table->integer('hipaa_readprivacy')->nullable()->default('1');
            $table->date('hipaa_date')->nullable();
            $table->string('hipaa_signature',255)->nullable();
            
            //Payment Agreement Form
            $table->string('payment_childsname',255)->nullable();
            $table->string('payment_parentsname',255)->nullable();
            $table->string('payment_parentssignature',255)->nullable();
            $table->string('payment_parentssocialsecurity',255)->nullable();
            $table->date('payment_parentsbirthday')->nullable();
            $table->date('payment_parentsdate')->nullable();
            
            //Informed Consent For Services
            $table->string('informed_childsname',255)->nullable();
            $table->string('informed_parentsname',255)->nullable();
            $table->date('informed_date')->nullable();
            $table->string('informed_signature',255)->nullable();
            
            //Security System Waiver
            $table->string('security_childsname',255)->nullable();
            $table->string('security_parentsname',255)->nullable();
            $table->text('security_grantsuccess')->nullable();
            $table->text('security_acknowledge')->nullable();
            $table->text('security_sospolicy')->nullable();
            $table->text('security_whenclients')->nullable();
            $table->date('security_date')->nullable();
            $table->string('security_signature',255)->nullable();
            
            //Release of Liability
            $table->string('release_childsname',255)->nullable();
            $table->string('release_parentsname',255)->nullable();
            $table->date('release_date')->nullable();
            $table->string('release_signature',255)->nullable();
            
            //Parent Handbook Agreement
            $table->string('parent_childsname',255)->nullable();
            $table->string('parent_parentsname',255)->nullable();
            $table->date('parent_date')->nullable();
            $table->string('parent_signature',255)->nullable();
            $table->text('pdf')->nullable();
            
            //Agreements
            $table->integer('agreement_hippa')->default(1);
            $table->integer('agreement_payment')->default(1);
            $table->integer('agreement_informed')->default(1);
            $table->integer('agreement_security')->default(1);
            $table->integer('agreement_release')->default(1);
            $table->integer('agreement_parent')->default(1);
            
			$table->rememberToken();
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
        Schema::dropIfExists('admission_form');
    }
}
