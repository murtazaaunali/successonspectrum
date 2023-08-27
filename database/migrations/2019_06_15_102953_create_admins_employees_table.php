<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('admin_id');
            $table->integer('employee_id');
            $table->string('employee_status',32);
            $table->enum('employee_title',['Directory of Administrator', 'Human Resources', 'Director of Operations', 'SOS Distribution']);
            $table->text('employee_address');
            $table->date('hiring_date');
            $table->string('employee_type',255);
            $table->date('employee_dob')->nullable();
            $table->date('ninty_days_probation_completion_date')->nullable();
            $table->text('highest_degree_held')->nullable();
            $table->string('employee_ss',191)->nullable();
            /*$table->decimal('starting_pay_rate',15,2)->nullable();
            $table->decimal('current_pay_rate',15,2)->nullable();*/
			$table->string('starting_pay_rate',199)->nullable();
            $table->string('current_pay_rate',199)->nullable();
            $table->enum('insurance_plan',['Yes', 'No'])->nullable();
            $table->enum('retirement_plan',['Yes', 'No'])->nullable();
            $table->integer('paid_vacation')->nullable();
            $table->integer('paid_holiday')->nullable();
            $table->integer('allowed_sick_leaves')->nullable();
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
        Schema::dropIfExists('admins_employees');
    }
}
