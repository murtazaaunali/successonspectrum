<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFemployeesTasklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('femployees_tasklist', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('employee_id');
            $table->text('task');
            $table->integer('sort')->default(0);
            $table->enum('status',['Incomplete','Complete']);
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
        Schema::dropIfExists('femployees_tasklist');
    }
}
