<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model {
	
	protected $table = 'product_images';
	public $timestamps = false;

	public $translatedAttributes = ['name'];
    protected $fillable = ['name', 'parent_id', 'image'];

    use \Dimsav\Translatable\Translatable;

	/* Creating rules */
	public static $rules_create = array(
		'name'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'name'=>'required',
	);
	                        
    public function parent() {
        return $this->belongsTo('Solunes\Product\App\Product');
    }
	                        
    public function product() {
        return $this->belongsTo('Solunes\Product\App\Product', 'parent_id');
    }

}