<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsReadByTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_read_by', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('notification_id');
            $table->enum('user_type',['Administration', 'Franchise Administration', 'Admin BCBA','Franchise BCBA','Admin Employee','Franchise Employee', 'SOS Distributor', 'Parent']);
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
        Schema::dropIfExists('notifications_read_by');
    }
}
