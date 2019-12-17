<?php

namespace Solunes\Product\App\Listeners;

class ProductSaving
{

    /**
     * Handle the event.
     *
     * @param  PodcastWasPurchased  $event
     * @return void
     */
    public function handle($event) {
        if(config('product.product_agency')&&!$event->agency_id){
            if(auth()->check()&&$agency_id = auth()->user()->agency_id){
                $event->agency_id = $agency_id;
            }
        }
        return $event;
    }
}

