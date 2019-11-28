<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model {
	
	protected $table = 'product_groups';
	public $timestamps = false;

	public $translatedAttributes = ['name'];
    protected $fillable = ['name'];

    use \Dimsav\Translatable\Translatable;
	/* Creating rules */
	public static $rules_create = array(
		
		'name'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'name'=>'required',
	);
	   
	public function product_group_subscription() {
        return $this->belongsToMany('Solunes\Customer\App\Subscription','product_group_subscription');
    }

}