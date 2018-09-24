<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;


class VariationOptionTranslation extends Model {
    
    protected $table = 'variation_option_translation';
    public $timestamps = false;
    protected $fillable = ['name','description'];

}