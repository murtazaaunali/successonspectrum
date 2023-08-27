<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFemployeesSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('femployees_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('admin_employee_id');
            $table->time('monday_time_in')->nullable();
            $table->time('monday_time_out')->nullable();
            $table->time('tuesday_time_in')->nullable();
            $table->time('tuesday_time_out')->nullable();
            $table->time('wednesday_time_in')->nullable();
            $table->time('wednesday_time_out')->nullable();
            $table->time('thursday_time_in')->nullable();
            $table->time('thursday_time_out')->nullable();
            $table->time('friday_time_in')->nullable();
            $table->time('friday_time_out')->nullable();
            $table->time('saturday_time_in')->nullable();
            $table->time('saturday_time_out')->nullable();
            $table->time('sunday_time_in')->nullable();
            $table->time('sunday_time_out')->nullable();
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
        Schema::dropIfExists('femployees_schedules');
    }
}
