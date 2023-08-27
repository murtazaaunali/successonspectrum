<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFemployeesTimePunchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('femployees_time_punch', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->enum('day',['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->string('total_hrs',10)->nullable();
            $table->integer('admin_employee_id')->nullable();
            $table->string('overtime_hrs',10)->nullable();
            $table->string('pto',191)->nullable();
            $table->string('remarks',191)->nullable();
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
        Schema::dropIfExists('_femployees_time_punch');
    }
}
