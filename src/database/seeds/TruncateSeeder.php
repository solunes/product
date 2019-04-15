<?php

namespace Solunes\Product\Database\Seeds;

use Illuminate\Database\Seeder;
use DB;

class TruncateSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(config('product.product_packages')){
            \Solunes\Product\App\PackageProduct::truncate();
            \Solunes\Product\App\PackageTranslation::truncate();
            \Solunes\Product\App\Package::truncate();
        }
        if(config('product.product_offers')){
            \Solunes\Product\App\ProductOfferTranslation::truncate();
            \Solunes\Product\App\ProductOffer::truncate();
        }
        if(config('product.product_images')){
            \Solunes\Product\App\ProductImageTranslation::truncate();        
            \Solunes\Product\App\ProductImage::truncate();
        }
        if(config('product.product_benefits')){
            \Solunes\Product\App\ProductBenefitTranslation::truncate();
            \Solunes\Product\App\ProductBenefit::truncate();
        }
        if(config('product.product_groups')){
            \Solunes\Product\App\ProductGroupTranslation::truncate();
            \Solunes\Product\App\ProductGroup::truncate();
        }
        \Solunes\Product\App\ProductTranslation::truncate();
        \Solunes\Product\App\Product::truncate();
        \Solunes\Product\App\CategoryTranslation::truncate();
        \Solunes\Product\App\Category::truncate();
        if(config('product.product_variations')){
            //\Solunes\Product\App\VariationTranslation::truncate();
            //\Solunes\Product\App\Variation::truncate();
        }
    }
}