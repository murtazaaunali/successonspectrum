<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchiseLocalAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchise_local_advertisements', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('franchise_id')->nullable();
			$table->year('year')->nullable();
			$table->enum('quarter',[1, 2, 3, 4])->nullable();
			$table->date('completion_date')->nullable();
            $table->enum('status',['Pending', 'Received', 'Not Applicable'])->nullable();
			$table->string('file');
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
        Schema::dropIfExists('franchise_local_advertisements');
    }
}
