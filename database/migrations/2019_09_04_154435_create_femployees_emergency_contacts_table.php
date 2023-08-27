<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFemployeesEmergencyContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('femployees_emergency_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('admin_employee_id');
            $table->string('relationship',191);
            $table->string('fullname',191);
            $table->string('phone_number',32);
            $table->string('email',191);
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
        Schema::dropIfExists('femployees_emergency_contacts');
    }
}
