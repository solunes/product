<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Category extends Model {
	
	protected $table = 'categories';
	public $timestamps = true;

    use Sluggable, SluggableScopeHelpers;
    public function sluggable(){
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

	/* Creating rules */
	public static $rules_create = array(
        'level'=>'required',
        'name'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
        'level'=>'required',
		'name'=>'required',
	);
	   
    public function children() {
        return $this->hasMany('Solunes\Product\App\Category', 'parent_id')->orderBy('order','ASC');
    }

    public function parent() {
        return $this->belongsTo('Solunes\Product\App\Category', 'parent_id');
    }

    public function variation() {
        return $this->belongsTo('Solunes\Product\App\Variation');
    }

    public function products() {
        return $this->hasMany('Solunes\Product\App\Product');
    }

}