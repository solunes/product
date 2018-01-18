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
        $node_variation = \Solunes\Master\App\Node::create(['name'=>'variation', 'location'=>'product', 'folder'=>'products']);
        $node_category = \Solunes\Master\App\Node::create(['name'=>'category', 'table_name'=>'categories', 'multilevel'=>true, 'location'=>'product', 'folder'=>'products']);
        $node_product = \Solunes\Master\App\Node::create(['name'=>'product', 'location'=>'product', 'folder'=>'products']);
        $node_product_group = \Solunes\Master\App\Node::create(['name'=>'product-group', 'location'=>'product', 'folder'=>'products']);
        $node_product_benefit = \Solunes\Master\App\Node::create(['name'=>'product-benefit', 'type'=>'subchild', 'location'=>'product', 'parent_id'=>$node_product->id]);
        $node_product_variation = \Solunes\Master\App\Node::create(['name'=>'product-variation', 'type'=>'field', 'model'=>'\App\Variation', 'location'=>'product', 'parent_id'=>$node_product->id]);
        \Solunes\Master\App\Node::create(['name'=>'product-image', 'type'=>'subchild', 'location'=>'product', 'parent_id'=>$node_product->id]);
        \Solunes\Master\App\Node::create(['name'=>'product-offer', 'type'=>'subchild', 'location'=>'product', 'parent_id'=>$node_product->id]);
        $node_package = \Solunes\Master\App\Node::create(['name'=>'package', 'location'=>'product', 'folder'=>'products']);
        $node_package_product = \Solunes\Master\App\Node::create(['name'=>'package-product', 'type'=>'child', 'location'=>'product', 'parent_id'=>$node_package->id]);
        // Usuarios
        $admin = \Solunes\Master\App\Role::where('name', 'admin')->first();
        $member = \Solunes\Master\App\Role::where('name', 'member')->first();
        $product_perm = \Solunes\Master\App\Permission::create(['name'=>'product', 'display_name'=>'Negocio']);
        $admin->permission_role()->attach([$product_perm->id]);

    }
}