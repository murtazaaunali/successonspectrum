<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFemployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('femployees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id');
            $table->integer('franchise_id');
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('profile_picture',255)->nullable();
            $table->string('password');

            $table->enum('employee_status',['Active','Terminated','Applicant'])->nullable();
            $table->enum('employee_title',['RBT Trainer', 'RBT', 'Uncertified', 'Technician'])->nullable();
            $table->text('employee_address')->nullable();
            $table->date('hiring_date')->nullable();
            $table->string('employee_type',255)->nullable();
            $table->date('employee_dob')->nullable();
            $table->date('ninty_days_probation_completion_date')->nullable();
            $table->text('highest_degree_held')->nullable();
            $table->string('employee_ss',191)->nullable();
            $table->decimal('starting_pay_rate',15,2)->nullable();
            $table->decimal('current_pay_rate',15,2)->nullable();
            $table->enum('insurance_plan',['Yes', 'No'])->nullable();
            $table->enum('retirement_plan',['Yes', 'No'])->nullable();
            $table->integer('paid_vacation')->nullable();
            $table->integer('paid_holiday')->nullable();
            $table->integer('allowed_sick_leaves')->nullable();
            $table->date('upcomming_performance')->nullable();
            
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
        Schema::drop('femployees');
    }
}
