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
        \Solunes\Product\App\PackageProduct::truncate();
        \Solunes\Product\App\Package::truncate();
        \Solunes\Product\App\ProductOffer::truncate();
        \Solunes\Product\App\ProductImage::truncate();
        \Solunes\Product\App\ProductBenefit::truncate();
        \Solunes\Product\App\ProductGroup::truncate();
        \Solunes\Product\App\Product::truncate();
        \Solunes\Product\App\Category::truncate();
        \Solunes\Product\App\Variation::truncate();
    }
}