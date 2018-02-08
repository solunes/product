<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;


class ProductImageTranslation extends Model {
    
    protected $table = 'product_image_translation';
    public $timestamps = false;
    protected $fillable = ['name'];

}