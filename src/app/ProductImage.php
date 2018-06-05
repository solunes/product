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
		'parent_id'=>'required',
		'name'=>'required',
		'image'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'parent_id'=>'required',
		'name'=>'required',
		'image'=>'required',
	);
	                        
    public function parent() {
        return $this->belongsTo('Solunes\Product\App\Product');
    }

}