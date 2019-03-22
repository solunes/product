<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;

class ProductBenefit extends Model {
	
	protected $table = 'product_benefits';
	public $timestamps = false;

	public $translatedAttributes = ['name'];
    protected $fillable = ['name', 'parent_id'];

    use \Dimsav\Translatable\Translatable;

	/* Creating rules */
	public static $rules_create = array(
		'parent_id'=>'required',
		'name'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'parent_id'=>'required',
		'name'=>'required',
	);
                        
    public function parent() {
        return $this->belongsTo('Solunes\Product\App\Product');
    }
                        
    public function product() {
        return $this->belongsTo('Solunes\Product\App\Product', 'parent_id');
    }

    public function place() {
        return $this->belongsTo('Solunes\Product\App\Place');
    }

}