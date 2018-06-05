<?php

namespace Solunes\Product\App;


use Illuminate\Database\Eloquent\Model;


class ProductGroupTranslation extends Model {
    
    protected $table = 'product_group_translation';
    public $timestamps = false;
    protected $fillable = ['name'];

}