<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchiseFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchise_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('contract_duration',['1 Year', '2 Years', '3 Years', '4 Years', '5 Years']);
            $table->integer('fee_due_date')->nullable();
            $table->integer('franchise_id');
            /*$table->decimal('initial_fee',15,2)->nullable();
            $table->decimal('monthly_royalty_fee',15,2);
			$table->decimal('monthly_royalty_fee_second_year',15,2);
			$table->decimal('monthly_royalty_fee_subsequent_years',15,2);
            $table->decimal('monthly_advertising_fee',15,2);
            $table->decimal('renewal_fee',15,2);*/
			$table->string('initial_fee')->nullable();
            $table->string('monthly_royalty_fee')->nullable();
			$table->string('monthly_royalty_fee_second_year')->nullable();
			$table->string('monthly_royalty_fee_subsequent_years')->nullable();
            $table->string('monthly_advertising_fee')->nullable();
            $table->string('renewal_fee')->nullable();
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
        Schema::dropIfExists('franchise_fees');
    }
}
