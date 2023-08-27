<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name',255);
            $table->text('product_description');
            $table->integer('product_category_id')->nullable();
            $table->integer('stock_quantity')->nullable();
            $table->string('tax',10)->nullable();
            $table->decimal('cost_price',15,2)->nullable();
            $table->decimal('selling_price',15,2)->nullable();
            $table->string('image',255)->nullable();
            $table->integer('creater_id')->nullable();
            $table->enum('creater_type',['Super Admin', 'Super Admin Employee', 'Franchise', 'Franchise Employee', 'Parent'])->nullable();
            $table->enum('stock_status',['In Stock', 'Out of Stock'])->nullable();
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
        Schema::dropIfExists('products');
    }
}
