<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model {
	
	protected $table = 'packages';
	public $timestamps = true;

	public $translatedAttributes = ['name'];
    protected $fillable = ['name', 'active', 'currency_id', 'price'];

    use \Dimsav\Translatable\Translatable;

	/* Creating rules */
	public static $rules_create = array(
        'name'=>'required',
		'active'=>'required',
		'currency_id'=>'required',
        'price'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
        'name'=>'required',
		'active'=>'required',
		'currency_id'=>'required',
        'price'=>'required',
	);

    public function currency() {
        return $this->belongsTo('Solunes\Product\App\Currency');
    }

}