<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargoholdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargohold', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('franchise_id')->nullable();
			$table->integer('folder_id')->nullable();
            $table->string('title',255);
            $table->date('expiration_date')->nullable();
            $table->enum('category',['Template Company Forms','Completed Franchisee Forms','Personal Documents','Employee Training','Parent Training','SOS Employee Forms','SOS Parent Forms','Franchise Forms','SOS Reports', 'Admin Employee Forms','Employee Default Forms','Parent Default Forms'])->nullable();
            $table->enum('user_type',['Admin', 'Admin Employee', 'Franchise', 'Franchise Employee', 'Parent']);
            $table->integer('user_id');
            $table->tinyInteger('archive')->default('0');
            $table->tinyInteger('shared_with_everyone')->default('0');
            $table->tinyInteger('shared_with_admin')->default('0');
            $table->tinyInteger('shared_with_franchise_admin')->default('0');
            $table->tinyInteger('shared_with_employees')->default('0');
            $table->tinyInteger('shared_with_clients')->default('0');
            $table->tinyInteger('shared_with_self')->default('0');
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
        Schema::dropIfExists('cargohold');
    }
}
