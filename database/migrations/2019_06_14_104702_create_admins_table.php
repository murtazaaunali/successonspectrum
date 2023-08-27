<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname',191);
            $table->integer('designation_id')->nullable()->default('0');
            $table->string('profile_picture',255)->nullable();
            $table->string('email',191)->unique();
            $table->string('password');
            $table->enum('type',['Super Admin', 'Employee'])->nullable();
            $table->tinyInteger('is_admin')->default('0');
            $table->rememberToken();

            $table->string('employee_status',32)->nullable();
            $table->enum('employee_title',['Director of Administration', 'Human Resources', 'Director of Operations', 'SOS Distribution'])->nullable();
            $table->text('employee_address')->nullable();
            $table->date('hiring_date')->nullable();
            $table->string('employee_type',255)->nullable();
            $table->date('employee_dob')->nullable();
            $table->date('ninty_days_probation_completion_date')->nullable();
            $table->text('highest_degree_held')->nullable();
            $table->string('employee_ss',191)->nullable();
            //$table->decimal('starting_pay_rate',15,2)->nullable();
			$table->string('starting_pay_rate',199)->nullable();
            //$table->decimal('current_pay_rate',15,2)->nullable();
			$table->string('current_pay_rate',199)->nullable();
            $table->enum('insurance_plan',['Yes', 'No'])->nullable();
            $table->enum('retirement_plan',['Yes', 'No'])->nullable();
            $table->integer('paid_vacation')->nullable();
            $table->integer('paid_holiday')->nullable();
            $table->integer('allowed_sick_leaves')->nullable();
            $table->date('upcomming_performance')->nullable();
            $table->date('satisfaction_survey')->nullable();
            $table->date('background_check')->nullable();
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
        Schema::drop('admins');
    }
}
