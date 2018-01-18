<?php

namespace Solunes\Product\App\Listeners;

class DealCreated {

    public function handle($event) {
    	// Revisar que no esté de manera externa
    	if($event&&!$event->external_code){
            $event = \Solunes\Product\App\Controllers\Integrations\HubspotController::exportDealCreated($event);
            return $event;
    	}
    }

}
