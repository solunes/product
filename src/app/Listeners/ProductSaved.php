<?php

namespace Solunes\Product\App\Listeners;

class ProductSaved
{

    /**
     * Handle the event.
     *
     * @param  PodcastWasPurchased  $event
     * @return void
     */
    public function handle($event) {
        if(!$product_bridge = \Solunes\Business\App\ProductBridge::where('product_type','product')->where('product_id', $event->id)->first()){
            $product_bridge = new \Solunes\Business\App\ProductBridge;
            $product_bridge->product_type = 'product';
            $product_bridge->product_id = $event->id;
        }
        $product_bridge->currency_id = 1;
        $product_bridge->price = $event->price;
        $product_bridge->name = $event->name;
        $image = \Asset::get_image_path('product-image','normal',$event->image);
        $product_bridge->image = \Asset::upload_image(asset($image),'product-bridge-image');
        $product_bridge->content = $event->content;
        $product_bridge->active = $event->active;
        if(config('payments.sfv_version')>1||config('payments.discounts')){
            $product_bridge->discount_price = $event->discount_price;
        }
        if(config('payments.sfv_version')>1){
            $product_bridge->economic_sin_activity = $event->economic_sin_activity;
            $product_bridge->product_sin_code = $event->product_sin_code;
            $product_bridge->product_internal_code = $event->product_internal_code;
            $product_bridge->product_serial_number = $event->product_serial_number;
        }
        if(config('solunes.inventory')){
            $product_bridge->stockable = $event->stockable;
        }
        $product_bridge->save();
        $array = [];
        if(config('product.product_variations')){
	        foreach($event->product_variation as $product_variation){
	            $array[$product_variation->id] = ['quantity'=>$product_variation->pivot->quantity,'new_price'=>$product_variation->pivot->new_price,'value'=>$product_variation->pivot->value];
	        }
	        $product_bridge->product_bridge_variation()->sync($array);
        }
        return $event;
    }
}

