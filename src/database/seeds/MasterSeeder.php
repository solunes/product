<?php

namespace Solunes\Product\Database\Seeds;

use Illuminate\Database\Seeder;
use DB;

class MasterSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(config('product.product_variations')){
            $node_variation = \Solunes\Master\App\Node::create(['name'=>'variation', 'location'=>'product', 'folder'=>'products']);
            \Solunes\Master\App\Node::create(['name'=>'variation-option', 'location'=>'product', 'folder'=>'products']);
        }
        $node_category = \Solunes\Master\App\Node::create(['name'=>'category', 'table_name'=>'categories', 'multilevel'=>true, 'location'=>'product', 'folder'=>'products']);
        $node_product = \Solunes\Master\App\Node::create(['name'=>'product', 'location'=>'product', 'folder'=>'products']);
        if(config('product.product_groups')){
            $node_product_group = \Solunes\Master\App\Node::create(['name'=>'product-group', 'location'=>'product', 'folder'=>'products']);
        }
        if(config('product.product_benefits')){
            $node_product_benefit = \Solunes\Master\App\Node::create(['name'=>'product-benefit', 'type'=>'subchild', 'location'=>'product', 'parent_id'=>$node_product->id]);
        }
        if(config('product.product_variations')){
            \Solunes\Master\App\Node::create(['name'=>'product-variation', 'table_name'=>'product_variation', 'model'=>'\Solunes\Product\App\Variation', 'type'=>'field', 'parent_id'=>$node_product->id]);
        }
        if(config('product.product_images')){
            \Solunes\Master\App\Node::create(['name'=>'product-image', 'type'=>'subchild', 'location'=>'product', 'parent_id'=>$node_product->id]);
        }
        if(config('product.product_offers')){
            \Solunes\Master\App\Node::create(['name'=>'product-offer', 'type'=>'subchild', 'location'=>'product', 'parent_id'=>$node_product->id]);
        }
        if(config('product.product_packages')){
            $node_package = \Solunes\Master\App\Node::create(['name'=>'package', 'location'=>'product', 'folder'=>'products']);
            $node_package_product = \Solunes\Master\App\Node::create(['name'=>'package-product', 'type'=>'child', 'location'=>'product', 'parent_id'=>$node_package->id]);
        }
        // Usuarios
        $admin = \Solunes\Master\App\Role::where('name', 'admin')->first();
        $member = \Solunes\Master\App\Role::where('name', 'member')->first();
        if(!$products_perm = \Solunes\Master\App\Permission::where('name','products')->first()){
            $products_perm = \Solunes\Master\App\Permission::create(['name'=>'products', 'display_name'=>'Productos']);
            $admin->permission_role()->attach([$products_perm->id]);
        }

    }
}