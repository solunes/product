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
            //$node_variation = \Solunes\Master\App\Node::create(['name'=>'variation', 'location'=>'product', 'folder'=>'products']);
            //\Solunes\Master\App\Node::create(['name'=>'variation-option', 'type'=>'child', 'location'=>'product', 'folder'=>'products', 'parent_id'=>$node_variation->id]);
        }
        $node_product = \Solunes\Master\App\Node::create(['name'=>'product', 'location'=>'product', 'folder'=>'products']);
        if(config('product.product_groups')){
            $node_product_group = \Solunes\Master\App\Node::create(['name'=>'product-group', 'location'=>'product', 'folder'=>'products']);
            if(config('customer.subscriptions')&&config('customer.subscription_products')){
                \Solunes\Master\App\Node::create(['name'=>'product-group-subscription', 'table_name'=>'product_group_subscription', 'type'=>'field', 'model'=>'\Solunes\Customer\App\Subscription', 'parent_id'=>$node_product_group->id]);
            }
        }
        if(config('product.product_benefits')){
            $node_product_benefit = \Solunes\Master\App\Node::create(['name'=>'product-benefit', 'type'=>'subchild', 'location'=>'product', 'parent_id'=>$node_product->id]);
        }
        if(config('product.product_variations')){
            \Solunes\Master\App\Node::create(['name'=>'product-variation', 'table_name'=>'product_bridge_variation', 'location'=>'product', 'translation'=>1, 'model'=>'\Solunes\Business\App\Variation', 'type'=>'field', 'parent_id'=>$node_product->id]);
            \Solunes\Master\App\Node::create(['name'=>'product-variation-option', 'table_name'=>'product_bridge_variation_option', 'location'=>'product',  'translation'=>1, 'model'=>'\Solunes\Business\App\VariationOption', 'type'=>'field', 'parent_id'=>$node_product->id]);
        }
        $image_folder = \Solunes\Master\App\ImageFolder::create(['site_id'=>1, 'name'=>'product-image', 'extension'=>'jpg']);
        \Solunes\Master\App\ImageSize::create(['parent_id'=>$image_folder->id, 'code'=>'normal', 'type'=>'resize', 'width'=>'1000']);
        \Solunes\Master\App\ImageSize::create(['parent_id'=>$image_folder->id, 'code'=>'thumb', 'type'=>'fit', 'width'=>'370', 'height'=>'370']);
        \Solunes\Master\App\ImageSize::create(['parent_id'=>$image_folder->id, 'code'=>'cart', 'type'=>'fit', 'width'=>'80', 'height'=>'100']);
        \Solunes\Master\App\ImageSize::create(['parent_id'=>$image_folder->id, 'code'=>'detail', 'type'=>'fit', 'width'=>'570', 'height'=>'570']);
        \Solunes\Master\App\ImageSize::create(['parent_id'=>$image_folder->id, 'code'=>'subdetail', 'type'=>'fit', 'width'=>'120', 'height'=>'120']);
        if(config('product.product_images')){
            \Solunes\Master\App\Node::create(['name'=>'product-image', 'type'=>'subchild', 'location'=>'product', 'parent_id'=>$node_product->id]);
            $image_folder = \Solunes\Master\App\ImageFolder::create(['site_id'=>1, 'name'=>'product-image-image', 'extension'=>'jpg']);
            \Solunes\Master\App\ImageSize::create(['parent_id'=>$image_folder->id, 'code'=>'normal', 'type'=>'resize', 'width'=>'1000']);
            \Solunes\Master\App\ImageSize::create(['parent_id'=>$image_folder->id, 'code'=>'thumb', 'type'=>'fit', 'width'=>'200', 'height'=>'200']);
            \Solunes\Master\App\ImageSize::create(['parent_id'=>$image_folder->id, 'code'=>'detail', 'type'=>'fit', 'width'=>'570', 'height'=>'570']);

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