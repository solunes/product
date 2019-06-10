<?php

return [

	// GENERAL
	'after_seed' => true,
	'product_images' => true,
	'product_url' => false,
	'product_sold_content' => false,
	'product_packages' => false,
	'product_benefits' => false,
	'product_groups' => false,
	'product_offers' => false,
	'product_variations' => false,
	'product_extras' => false,
	'category_image' => true,
	'category_description' => true,
	'product_description' => true,
	'product_extra_description' => false,

	// CUSTOM FORMS
    'item_get_after_vars' => ['purchase','product'], // array de nodos: 'node'
    'item_child_after_vars' => ['product'],
    'item_remove_scripts' => ['purchase'=>['leave-form']],
    'item_add_script' => ['purchase'=>['barcode-product'], 'product'=>['product']],

];