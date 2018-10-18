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
        if(config('product.product_variations')){
            Schema::create('variations', function (Blueprint $table) {
                $table->increments('id');
                $table->enum('type', ['choice','quantities'])->default('choice');
                $table->enum('subtype', ['normal', 'color', 'image'])->nullable()->default('normal');
                $table->integer('max_choices')->nullable()->default(0);
                $table->boolean('optional')->nullable()->default(0);
                $table->timestamps();
            });
            Schema::create('variation_translation', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('variation_id')->unsigned();
                $table->string('locale')->index();
                $table->string('name')->nullable();
                $table->string('label')->nullable();
                $table->unique(['variation_id','locale']);
                $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
            });
            Schema::create('variation_options', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id')->nullable();
                $table->decimal('extra_price', 10, 2)->nullable()->default(0);
                $table->integer('max_quantity')->nullable()->default(0);
                $table->timestamps();
            });
            Schema::create('variation_option_translation', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('variation_option_id')->unsigned();
                $table->string('locale')->index();
                $table->string('name')->nullable();
                $table->string('description')->nullable();
                $table->unique(['variation_option_id','locale']);
                $table->foreign('variation_option_id')->references('id')->on('variation_options')->onDelete('cascade');
            });
        }
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->integer('level')->nullable();
            $table->integer('order')->nullable()->default(0);
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
        if(config('product.category_image')){
            Schema::table('categories', function (Blueprint $table) {
                $table->string('image')->nullable();
            });
        }
        Schema::create('category_translation', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->unique(['category_id','locale']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barcode')->nullable();
            $table->integer('category_id')->unsigned();
            $table->string('slug')->nullable();
            $table->string('product_size')->nullable(); // Retirar y cambiar por variantes
            $table->string('image')->nullable();
            $table->boolean('printed')->nullable()->default(0);
            $table->integer('currency_id')->unsigned();
            $table->decimal('weight', 10, 2)->nullable()->default(0);
            $table->decimal('cost', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
        if(config('product.product_extras')){
            Schema::table('products', function (Blueprint $table) {
                $table->integer('partner_id')->nullable();
                $table->integer('partner_transport_id')->nullable();
                $table->integer('external_currency_id')->unsigned();
                $table->decimal('currency_product_cost', 10, 2)->nullable();
                $table->decimal('currency_transport_cost', 10, 2)->nullable();
                $table->decimal('exchange', 10, 2)->nullable();
                $table->decimal('product_cost', 10, 2)->nullable();
                $table->decimal('transport_cost', 10, 2)->nullable();
                $table->decimal('no_invoice_price', 10, 2)->nullable();
                $table->decimal('offer_price', 10, 2)->nullable();
            });
        }
        if(config('product.product_groups')){
            Schema::table('products', function (Blueprint $table) {
                $table->integer('product_group_id')->nullable();
            });
        }
        Schema::create('product_translation', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->unique(['product_id','locale']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        if(config('product.product_description')){
            Schema::table('product_translation', function (Blueprint $table) {
                $table->text('description')->nullable();
            });
        }
        if(config('product.product_extra_description')){
            Schema::table('product_translation', function (Blueprint $table) {
                $table->text('extra_description')->nullable();
            });
        }
        if(config('product.product_groups')){
            Schema::create('product_groups', function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
            });
            Schema::create('product_group_translation', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('product_group_id')->unsigned();
                $table->string('locale')->index();
                $table->string('name')->nullable();
                $table->unique(['product_group_id','locale']);
                $table->foreign('product_group_id')->references('id')->on('product_groups')->onDelete('cascade');
            });
        }
        if(config('product.product_variations')){
            Schema::create('product_variation', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('product_id')->unsigned();
                $table->integer('variation_id')->unsigned();
                $table->integer('quantity')->nullable();
                $table->decimal('new_price',10,2)->nullable();
                $table->string('value')->nullable();
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
            });
        }
        if(config('product.product_benefits')){
            Schema::create('product_benefits', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id')->unsigned();
                $table->string('name')->nullable();
                $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');
            });
            Schema::create('product_benefit_translation', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('product_benefit_id')->unsigned();
                $table->string('locale')->index();
                $table->string('name')->nullable();
                $table->unique(['product_benefit_id','locale']);
                $table->foreign('product_benefit_id')->references('id')->on('product_benefits')->onDelete('cascade');
            });
        }
        if(config('product.product_images')){
            Schema::create('product_images', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id')->unsigned();
                $table->string('image')->nullable();
                $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');
            });
            Schema::create('product_image_translation', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('product_image_id')->unsigned();
                $table->string('locale')->index();
                $table->string('name')->nullable();
                $table->unique(['product_image_id','locale']);
                $table->foreign('product_image_id')->references('id')->on('product_images')->onDelete('cascade');
            });
        }
        if(config('product.product_offers')){
            Schema::create('product_offers', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id')->unsigned();
                $table->enum('type', ['discount_percentage','discount_value','discount_quantities'])->nullable()->default('discount_percentage');
                $table->string('value')->nullable();
                $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');
            });
            Schema::create('product_offer_translation', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('product_offer_id')->unsigned();
                $table->string('locale')->index();
                $table->string('name')->nullable();
                $table->unique(['product_offer_id','locale']);
                $table->foreign('product_offer_id')->references('id')->on('product_offers')->onDelete('cascade');
            });
        }
        if(config('product.product_packages')){
            Schema::create('packages', function (Blueprint $table) {
                $table->increments('id');
                $table->boolean('active')->nullable()->default(1);
                $table->integer('currency_id')->unsigned();
                $table->string('price')->nullable();
                $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            });
            Schema::create('package_translation', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('package_id')->unsigned();
                $table->string('locale')->index();
                $table->string('name')->nullable();
                $table->unique(['package_id','locale']);
                $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_products');
        Schema::dropIfExists('package_translation');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('product_offer_translation');
        Schema::dropIfExists('product_offers');
        Schema::dropIfExists('product_image_translation');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_benefit_translation');
        Schema::dropIfExists('product_benefits');
        Schema::dropIfExists('product_variation');
        Schema::dropIfExists('product_group_translation');
        Schema::dropIfExists('product_groups');
        Schema::dropIfExists('product_translation');
        Schema::dropIfExists('products');
        Schema::dropIfExists('category_translation');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('variation_option_translation');
        Schema::dropIfExists('variation_options');
        Schema::dropIfExists('variation_translation');
        Schema::dropIfExists('variations');
    }
}
