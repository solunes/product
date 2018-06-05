<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model {
	
	protected $table = 'variations';
	public $timestamps = true;

	public $translatedAttributes = ['name'];
    protected $fillable = ['name', 'type'];

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