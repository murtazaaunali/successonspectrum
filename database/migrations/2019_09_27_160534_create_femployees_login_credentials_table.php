<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFemployeesLoginCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('femployees_login_credentials', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('admin_employee_id');
			$table->string('app_name',191);
			$table->text('url')->nullable();
			$table->string('username',191);
			$table->string('password',191);
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
        Schema::dropIfExists('femployees_login_credentials');
    }
}
