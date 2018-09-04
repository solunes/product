<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model {
	
	protected $table = 'product_variation';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'name'=>'required',
		'image'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'name'=>'required',
		'image'=>'required',
	);
	
}