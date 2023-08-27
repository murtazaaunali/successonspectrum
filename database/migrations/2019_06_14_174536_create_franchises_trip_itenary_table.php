<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchisesTripItenaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchises_trip_itenary', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->enum('day',['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->enum('trip_iternary_type',['Event', 'Meeting', 'Assesment'])->nullable();
            $table->string('trip_iternary_name',191)->nullable();
            $table->integer('franchise_id')->nullable();
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
        Schema::dropIfExists('franchises_trip_itenary');
    }
}
