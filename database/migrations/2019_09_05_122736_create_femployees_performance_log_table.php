<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFemployeesPerformanceLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('femployees_performance_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('event',191);
            $table->string('comment',191)->nullable();
            $table->text('description',191)->nullable();
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
        Schema::dropIfExists('femployees_performance_log');
    }
}
