<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;

class VariationOption extends Model {
	
	protected $table = 'variation_options';
	public $timestamps = true;

	public $translatedAttributes = ['name','description'];
    protected $fillable = ['name','description','extra_price','max_quantity'];

    use \Dimsav\Translatable\Translatable;

	/* Creating rules */
	public static $rules_create = array(
		'name'=>'required',
		'type'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'name'=>'required',
		'type'=>'required',
	);
	
    public function node() {
        return $this->belongsTo('Solunes\Master\App\Node');
    }
	
}