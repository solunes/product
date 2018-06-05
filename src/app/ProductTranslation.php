<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;


class ProductTranslation extends Model {
    
    protected $table = 'product_translation';
    public $timestamps = false;
    protected $fillable = ['name'];

}