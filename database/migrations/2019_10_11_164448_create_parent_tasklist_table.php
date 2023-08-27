<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentTasklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_tasklist', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('client_id');
            $table->enum('group',['Potential','Admissions','Enrollment Process']);
			$table->text('task');
            $table->integer('sort')->default(0);
            $table->enum('status',['Incomplete','Complete']);
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
        Schema::dropIfExists('parent_tasklist');
    }
}
