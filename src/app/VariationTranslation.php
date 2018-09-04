<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;


class VariationTranslation extends Model {
    
    protected $table = 'variation_translation';
    public $timestamps = false;
    protected $fillable = ['name','label'];

}