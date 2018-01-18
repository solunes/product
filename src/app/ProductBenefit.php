<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;

class ProductBenefit extends Model {
	
	protected $table = 'product_benefits';
	public $timestamps = false;

	/* Transfer rules */
	public static $rules_transfer = array(
		'product_stock_id'=>'required',
		'place_id'=>'required',
	);

	/* Remove rules */
	public static $rules_remove = array(
		'product_stock_id'=>'required',
		'name'=>'required',
	);

	/* Creating rules */
	public static $rules_create = array(
		'place_id'=>'required',
		'quantity'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'place_id'=>'required',
		'quantity'=>'required',
	);
                        
    public function parent() {
        return $this->belongsTo('Solunes\Product\App\Product');
    }

    public function place() {
        return $this->belongsTo('Solunes\Product\App\Place');
    }

}