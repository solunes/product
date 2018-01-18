<?php

namespace Solunes\Product\App\Listeners;

class CompanyCreated {

    public function handle($event) {
    	// Revisar que no esté de manera externa
    	if($event&&!$event->external_code){
            $event = \Solunes\Product\App\Controllers\Integrations\HubspotController::exportCompanyCreated($event);
            return $event;
    	}
    }

}
