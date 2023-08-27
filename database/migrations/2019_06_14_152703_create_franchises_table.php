<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('profile_picture',255)->nullable();
            $table->text('location')->nullable();
            $table->text('address')->nullable();
            $table->string('city',191)->nullable();
            $table->string('zipcode',32)->nullable();
            $table->integer('state')->nullable();
            $table->string('email',191)->unique();
            $table->string('password',191)->nullable();
            $table->string('phone',32)->nullable();
            $table->string('fax',32)->nullable();
            $table->text('client_address')->nullable();
            $table->string('client_city',191)->nullable();
            $table->string('client_zipcode',32)->nullable();
            $table->integer('client_state')->nullable();
            $table->date('franchise_activation_date')->nullable();
            $table->enum('status',['Active','Expired','Terminated','Potential']);
            $table->integer('created_by')->nullable();
            $table->date('fdd_signed_date')->nullable();
            $table->date('fdd_expiration_date')->nullable();
			$table->date('upcoming_audit_date')->nullable();
            $table->dateTime('contract_startdate')->nullable();
            $table->dateTime('contract_enddate')->nullable();
			$table->integer('incomplete_tasks')->nullable();
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
        Schema::drop('franchises');
    }
}
