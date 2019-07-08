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
            /*Schema::create('variations', function (Blueprint $table) {
                $table->increments('id');
                $table->enum('type', ['choice','quantities'])->default('choice');
                $table->enum('subtype', ['normal', 'color', 'image'])->nullable()->default('normal');
                if(config('solunes.inventory')){
                    $table->boolean('stockable')->nullable()->default(1);
                }
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
            });*/
        }
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            if(config('business.product_barcode')){
                $table->string('barcode')->nullable();
            }
            $table->integer('category_id')->nullable();
            $table->string('slug')->nullable();
            //$table->string('product_size')->nullable(); // Retirar y cambiar por variantes
            $table->string('image')->nullable();
            if(config('business.product_barcode')){
                $table->boolean('printed')->nullable()->default(0);
            }
            $table->integer('currency_id')->unsigned();
            $table->decimal('weight', 10, 2)->nullable()->default(0);
            $table->decimal('cost', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            if(config('payments.sfv_version')>1||config('payments.discounts')){
                $table->decimal('discount_price', 10, 2)->nullable();
            }
            if(config('payments.sfv_version')>1){
                $table->string('economic_sin_activity')->nullable();
                $table->string('product_sin_code')->nullable();
                $table->string('product_internal_code')->nullable();
                $table->string('product_serial_number')->nullable(); // Para linea blanca y celulares
            }
            if(config('solunes.inventory')){
                $table->boolean('stockable')->nullable()->default(1);
            }
            $table->enum('delivery_type', ['normal','digital'])->nullable()->default('normal');
            if(config('product.product_url')){
                $table->string('product_url')->nullable();
            }
            $table->boolean('active')->default(1);
            if(config('product.product_groups')){
                $table->integer('product_group_id')->nullable();
            }
            $table->timestamps();
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
        Schema::create('product_translation', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name')->nullable();
            if(config('product.product_description')){
                $table->text('description')->nullable();
            }
            if(config('product.product_sold_content')){
                $table->text('sold_content')->nullable();
            }
            if(config('product.product_extra_description')){
                $table->text('extra_description')->nullable();
            }
            $table->unique(['product_id','locale']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
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
        /*if(config('product.product_variations')){
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
        }*/
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
        //Schema::dropIfExists('product_variation');
        Schema::dropIfExists('product_group_translation');
        Schema::dropIfExists('product_groups');
        Schema::dropIfExists('product_translation');
        Schema::dropIfExists('products');
        /*Schema::dropIfExists('variation_option_translation');
        Schema::dropIfExists('variation_options');
        Schema::dropIfExists('variation_translation');
        Schema::dropIfExists('variations');*/
    }
}
