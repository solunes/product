<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;


class ProductBenefitTranslation extends Model {
    
    protected $table = 'product_benefit_translation';
    public $timestamps = false;
    protected $fillable = ['name'];

}