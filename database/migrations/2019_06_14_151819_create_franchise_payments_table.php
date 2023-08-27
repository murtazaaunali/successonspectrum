<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchisePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchise_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('invoice_name',['Initial Franchise Fee', 'Monthly Royalty Fee', 'Monthly System Advertising Fee', 'Renewal Fee']);
            $table->decimal('amount',15,2)->nullable();
            $table->enum('status',['Paid', 'Overdue'])->nullable();
            $table->enum('type',['Day', 'Week', 'Month', 'Annual', 'One Time'])->nullable();
            $table->string('month',32)->nullable();
            $table->decimal('late_fee',15,2)->nullable();
            $table->text('comment')->nullable();
            $table->integer('franchise_id')->nullable();
            $table->date('payment_recieved_on')->nullable();
            $table->enum('action',['Received','Not Received','Overdue'])->nullable();
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
        Schema::dropIfExists('franchise_payments');
    }
}
