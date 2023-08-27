<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionFormDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_form_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('client_id');
			$table->enum('document',['Childs Dignostic', 'Childs IEP'])->nullable();
			$table->string('document_name',191)->nullable();
			$table->string('document_file',255)->nullable();
			$table->tinyInteger('archive')->default('0');
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
        Schema::dropIfExists('admission_form_documents');
    }
}
