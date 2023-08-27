<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchiseAuditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchise_audit', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('franchise_id')->nullable();
            $table->year('from_year')->nullable();
			$table->year('to_year')->nullable();
			$table->date('conducted_date')->nullable();
            $table->enum('status',['Pending', 'Completed', 'Not Conducted'])->nullable();
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
        Schema::dropIfExists('franchise_local_audit');
    }
}
