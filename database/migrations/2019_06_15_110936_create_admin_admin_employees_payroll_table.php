<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAdminEmployeesPayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_admin_employees_payroll', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('hours',15,2);
            $table->decimal('short_hours',15,2);
            $table->decimal('overtime',15,2)->nullable();
            $table->integer('admin_employee_id');
            $table->decimal('hourly_rate',15,2)->nullable();
            $table->decimal('total_amount',15,2)->nullable();
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
        Schema::dropIfExists('admin_admin_employees_payroll');
    }
}
