<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchiseInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchise_insurance', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('franchise_id')->nullable();
			$table->enum('insurance_type',['General liability insurance', 'Professional liability insurance', 'Property and casualty insurance', 'Business interruption insurance','Workers compensation insurance']);
            $table->date('expiration_date')->nullable();
            //$table->enum('status',['Received', 'Not Received', 'Updated', 'Not Updated'])->nullable();
			$table->enum('status',['Active', 'Expired'])->nullable();
            $table->string('file',255)->nullable();
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
        Schema::dropIfExists('franchise_insurance');
    }
}
