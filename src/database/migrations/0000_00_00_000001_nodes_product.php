<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NodesProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->enum('type', ['normal', 'color', 'image'])->nullable()->default('normal');
            $table->timestamps();
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->integer('level')->nullable();
            $table->integer('order')->nullable()->default(0);
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barcode')->nullable();
            $table->integer('category_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('product_size')->nullable(); // Retirar y cambiar por variantes
            $table->string('image')->nullable();
            $table->boolean('printed')->nullable()->default(0);
            $table->integer('currency_id')->unsigned();
            $table->integer('partner_id')->nullable();
            $table->integer('partner_transport_id')->nullable();
            $table->integer('external_currency_id')->unsigned();
            $table->decimal('currency_product_cost', 10, 2)->nullable();
            $table->decimal('currency_transport_cost', 10, 2)->nullable();
            $table->decimal('weight', 10, 2)->nullable()->default(0);
            $table->decimal('exchange', 10, 2)->nullable();
            $table->decimal('product_cost', 10, 2)->nullable();
            $table->decimal('transport_cost', 10, 2)->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('no_invoice_price', 10, 2)->nullable();
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->integer('product_group_id')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
        Schema::create('product_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });
        Schema::create('product_variation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('variation_id')->unsigned();
            $table->string('value')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
        });
        Schema::create('product_benefits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->string('name')->nullable();
            $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::create('product_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->string('name')->nullable();
            $table->enum('type', ['discount_percentage','discount_value','discount_quantities'])->nullable()->default('discount_percentage');
            $table->string('value')->nullable();
            $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->boolean('active')->nullable()->default(1);
            $table->integer('currency_id')->unsigned();
            $table->string('price')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
        Schema::create('package_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('quantity')->nullable();
            $table->foreign('parent_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_products');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('product_offers');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_benefits');
        Schema::dropIfExists('product_variation');
        Schema::dropIfExists('product_groups');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('variations');
    }
}
