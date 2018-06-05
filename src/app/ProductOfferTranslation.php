<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;


class ProductOfferTranslation extends Model {
    
    protected $table = 'product_offer_translation';
    public $timestamps = false;
    protected $fillable = ['name'];

}