<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('franchise_id');
            $table->string('fullname')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->enum('type',['Owner','Manager','BCBA','Intern','Receptionist']);
            $table->string('profile_picture','255')->nullable();
			$table->string('remember_token','100')->nullable();
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
        Schema::dropIfExists('fusers');
    }
}
