<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('message')->nullable();
            $table->enum('message_to',
        		[
        			'Administration', 
        			'Franchise Administration', 
        			'Admin BCBA',
        			'Franchise BCBA',
        			'Admin Employee',
        			'Franchise Employee', 
        			'Employee', 
        			'Parent'
        			'SOS Distributor',
        			'Director Of Operations',
        			'Director Of Administration',
        			'Human Resources'
        		]
            );
            $table->enum('sender_type',
        		[
        			'Administration', 
        			'Franchise Administration', 
        			'Admin BCBA',
        			'Franchise BCBA',
        			'Admin Employee',
        			'Franchise Employee', 
        			'Employee', 
        			'Parent'
        			'SOS Distributor',
        			'Director Of Operations',
        			'Director Of Administration',
        			'Human Resources'
        		]
            );
            $table->integer('sender_id')->nullable();
            $table->integer('reciever_id')->nullable();
            $table->integer('franchise_id')->nullable()->default(0);
            $table->text('file')->nullable();
            $table->integer('is_private')->nullable()->default(0);
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
        Schema::dropIfExists('messages');
    }
}
