<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->text('description');
            $table->text('old_description')->nullable();
            $table->text('attachment')->nullable();
            $table->enum('type',['Announcement','Update','Notice','Activity','Message']);
            $table->tinyInteger('send_to_everyone')->default('0');
            $table->tinyInteger('send_to_franchise_admin')->default('0');
            $table->tinyInteger('send_to_employees')->default('0');
            $table->tinyInteger('send_to_clients')->default('0');
            $table->tinyInteger('send_to_admin')->default('0');
            $table->tinyInteger('archive')->default('0');
            $table->integer('user_id');
            $table->enum('user_type',['Administration', 'Franchise Administration', 'Admin BCBA','Franchise BCBA','Admin Employee','Franchise Employee', 'SOS Distributor', 'Parent','Director of Administration']);
            $table->enum('send_to_type',['Administration', 'Franchise Administration', 'Admin BCBA','Franchise BCBA','Admin Employee', 'SOS Distributor', 'Director of Administration', 'All Franchises', 'Franchise']);
            $table->enum('notification_type',['System Notification','Custom Notification']);
			$table->enum('notification_groups',['tasklist','others']);
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
        Schema::dropIfExists('notifications');
    }
}
