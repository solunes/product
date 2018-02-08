<?php

namespace Solunes\Product\App;


use Illuminate\Database\Eloquent\Model;


class PackageTranslation extends Model {
    
    protected $table = 'package_translation';
    public $timestamps = false;
    protected $fillable = ['name'];

}