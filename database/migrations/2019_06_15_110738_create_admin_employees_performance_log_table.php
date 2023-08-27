<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminEmployeesPerformanceLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_employees_performance_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('event',191);
            $table->string('comment',191)->nullable();
            $table->text('description')->nullable();
            $table->integer('admin_employee_id')->nullable();
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
        Schema::dropIfExists('admin_employees_performance_log');
    }
}
