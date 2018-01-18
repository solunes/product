<?php

namespace Solunes\Product;

use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot() {
        /* Publicar Elementos */
        $this->publishes([
            __DIR__ . '/config' => config_path()
        ], 'config');
        $this->publishes([
            __DIR__.'/assets' => public_path('assets/product'),
        ], 'assets');

        /* Cargar Traducciones */
        $this->loadTranslationsFrom(__DIR__.'/lang', 'product');

        /* Cargar Vistas */
        $this->loadViewsFrom(__DIR__ . '/views', 'product');
    }


    public function register() {
        /* Registrar ServiceProvider Internos */

        /* Registrar Alias */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();

        $loader->alias('Product', '\Solunes\Product\App\Helpers\Product');
        $loader->alias('CustomProduct', '\Solunes\Product\App\Helpers\CustomProduct');

        /* Comandos de Consola */
        $this->commands([
            //\Solunes\Product\App\Console\AccountCheck::class,
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/config/product.php', 'product'
        );
    }
    
}
