<?php

namespace Solunes\Product\App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Solunes\Master\App\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        
        // Módulo de Proyectos
        $events->listen('eloquent.creating: Solunes\Product\App\BankAccount', '\Solunes\Product\App\Listeners\RegisteringBankAccount');

        parent::boot($events);
    }
}
