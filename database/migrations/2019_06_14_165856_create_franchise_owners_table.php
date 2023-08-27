<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchiseOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchise_owners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname',255)->nullable();
            $table->integer('franchise_id')->nullable();
            $table->string('profile_picture',255)->nullable();
            $table->string('phone',32)->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('franchise_owners');
    }
}
