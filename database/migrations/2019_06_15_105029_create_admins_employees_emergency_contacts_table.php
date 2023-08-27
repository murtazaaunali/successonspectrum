<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsEmployeesEmergencyContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins_employees_emergency_contacts', function (Blueprint $table) {
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
        Schema::dropIfExists('admins_employees_emergency_contacts');
    }
}
