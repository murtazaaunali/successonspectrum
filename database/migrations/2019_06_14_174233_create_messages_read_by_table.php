<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesReadByTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_read_by', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('message_id');
            $table->enum('user_type',['Admin', 'Admin Employee', 'Franchise', 'Franchise Employee', 'Employee', 'Parent']);
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('messages_read_by');
    }
}
