<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rayon_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('category');
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->integer('stock_threshold')->default(10);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_on_sale')->default(false);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}