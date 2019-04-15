<?php

namespace Solunes\Product\App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;

class Product extends Model {
	
	protected $table = 'products';
	public $timestamps = true;

    public $translatedAttributes = ['name','description'];
    protected $fillable = ['name','description','category_id','currency_id', 'external_currency_id', 'partner_id', 'partner_transport_id', 'barcode', 'cost', 'price', 'no_invoice_price', 'printed','active'];

    use \Dimsav\Translatable\Translatable;
    use PivotEventTrait;

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
		'category_id'=>'required',
        'currency_id'=>'required',
        //'barcode'=>'required',
        'name'=>'required',
        'active'=>'required',
        'price'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
        'category_id'=>'required',
        'currency_id'=>'required',
        //'barcode'=>'required',
        'name'=>'required',
        'active'=>'required',
        'price'=>'required',
	);

    public function category() {
        return $this->belongsTo('Solunes\Product\App\Category');
    }

    public function currency() {
        return $this->belongsTo('Solunes\Business\App\Currency');
    }

    public function product_group() {
        return $this->belongsTo('Solunes\Product\App\ProductGroup');
    }

    public function product_variation() {
        return $this->belongsToMany('Solunes\Business\App\Variation', 'product_variation', 'product_id', 'variation_id');
    }

    public function product_benefits() {
        return $this->hasMany('Solunes\Product\App\ProductBenefit', 'parent_id');
    }

    public function product_stocks() {
        return $this->hasMany('Solunes\Inventory\App\ProductStock', 'parent_id');
    }

    public function product_images() {
        return $this->hasMany('Solunes\Product\App\ProductImage', 'parent_id');
    }

    public function product_offers() {
        return $this->hasMany('Solunes\Product\App\ProductOffer', 'parent_id');
    }

    public function product_offer() {
        return $this->hasOne('Solunes\Product\App\ProductOffer', 'parent_id');
    }

    public function purchase_products() {
        return $this->hasMany('Solunes\Inventory\App\PurchaseProduct');
    }

    public function product_bridge() {
        return $this->hasOne('Solunes\Business\App\ProductBridge')->where('product_type', 'product');
    }

    public function variation_option() {
        return $this->belongsTo('Solunes\Business\App\VariationOption');
    }

    public function getTotalStockAttribute() {
        if(count($this->product_stocks)>0){
            return $this->product_stocks->sum('quantity');
        } else {
            return 0;
        }
    }

    public function getRealPriceAttribute() {
        $price = $this->price;
        if($offer = $this->product_offer){
            if($offer->type=='discount_percentage'){
                $price = $price - ($price * $offer->value / 100);
            } else if($offer->type=='discount_value'){
                $price = $price - $offer->value;
            }
        }
        return $price;
    }

    public function getPriceLabelAttribute() {
        $price = round($this->price, 2);
        $real_price = round($this->real_price, 2);
        if($price != $real_price){
            return '<span class="old-price">ANTES A '.$price.' '.$this->currency->name.'</span><br><span class="new-price">AHORA A '.$real_price.' '.$this->currency->name.'</span>';
        } else if($offer = $this->product_offer&&$this->product_offer->type=='discount_quantities') {
            $return = '<span class="new-price">'.$price.' '.$this->currency->name.'</span>';
            $return .= '<br><span class="new-price">LLEVATE '.$this->product_offer->value.'</span>';
            return $return;
        } else {
            return '<span class="new-price">CÓMPRALO POR:<br>'.$price.' '.$this->currency->name.'</span>';
        }
    }

    public function item_get_after_vars($module, $node, $single_model, $id, $variables){
        //$variables['no_invoice_reduction'] = \App\Variable::where('name', 'reduccion_sin_factura')->first()->value;
        $variables['no_invoice_reduction'] = 16;
        return $variables;
    }

    public function item_child_after_vars($module, $node, $single_model, $id, $variables){
        //$variables['no_invoice_reduction'] = \App\Variable::where('name', 'reduccion_sin_factura')->first()->value;
        $variables['no_invoice_reduction'] = 16;
        return $variables;
    }

    public static function boot() {
        static::pivotAttached(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
            if($relationName=='product_variation'){
                $product_bridge = $model->product_bridge;
                foreach($pivotIds as $pivotId){
                    $variation = \Solunes\Business\App\Variation::find($pivotId);
                    foreach($variation->variation_options as $variation_option){
                      if(!\Solunes\Business\App\ProductBridgeVariationOption::where('product_bridge_id', $product_bridge->id)->where('variation_id', $variation->id)->where('variation_option_id', $variation_option->id)->first())
                        $pb_variation_option = new \Solunes\Business\App\ProductBridgeVariationOption;
                        $pb_variation_option->product_bridge_id = $product_bridge->id;
                        $pb_variation_option->variation_id = $variation->id;
                        $pb_variation_option->variation_option_id = $variation_option->id;
                        $pb_variation_option->save();
                    }
                }
                if(config('solunes.inventory')){
                    $agencies = \Solunes\Business\App\Agency::where('stockable', 1)->get();
                    foreach($product_bridge->product_bridge_variation_options()->get() as $product_bridge_variation_option){
                        foreach($agencies as $agency){
                            \Inventory::increase_inventory($agency, $product_bridge, $product_bridge_variation_option, 0);
                        }
                    }
                }
            }

        });
    }

}