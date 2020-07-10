<?php

namespace Apvanlaan\UsaEpay;

use Illuminate\Support\ServiceProvider;

class UsaEpayServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'apvanlaan');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-usaepay');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/usaepay.php', 'usaepay');

        // Register the service the package provides.
        $this->app->singleton('usaepay', function ($app) {
            return new UsaEpay;
        });
        $this->app->singleton('epaycustomer', function ($app) {
            return new EpayCustomer;
        });
        $this->app->singleton('epaytransaction', function ($app) {
            return new EpayTransaction;
        });
        $this->app->singleton('epaybatch', function ($app) {
            return new EpayBatch;
        });
        $this->app->singleton('epayproduct', function ($app) {
            return new EpayProduct;
        });
        $this->app->singleton('epaycategory', function ($app) {
            return new EpayCategory;
        });
        $this->app->singleton('epayamoutndetail', function ($app) {
            return new Transactions\EpayAmountDetail;
        });
        $this->app->singleton('epaycreditcard', function ($app) {
            return new Transactions\EpayCreditCard;
        });
        $this->app->singleton('epaycustomeraddress', function ($app) {
            return new Transactions\EpayCustomerAddress;
        });
        $this->app->singleton('epaycustomfield', function ($app) {
            return new Transactions\EpayCustomField;
        });
        $this->app->singleton('epaylineitem', function ($app) {
            return new Transactions\EpayLineItem;
        });
        $this->app->singleton('epaytrait', function ($app) {
            return new Transactions\EpayTrait;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['usaepay', 'epaycustomer', 'epaytransaction', 'epaybatch', 'epayproduct', 'epaycategory', 'epayamountdetail', 'epaycreditcard', 'epaycustomeraddress', 'epaycustomfield', 'epaylineitem', 'epaytrait'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/usaepay.php' => config_path('usaepay.php'),
        ], 'usaepay.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/laravel-usaepay'),
        ], 'usaepay.views');

        // Publishing assets.
        $this->publishes([
            __DIR__.'/../src/resources/' => public_path('/'),
        ], 'usaepay.assets');

        // Publishing CreditCard Component
        $this->publishes([
            __DIR__.'/../resources/assets/js/components' => resource_path('js/components'),
        ], 'usaepay.creditcard');
        $this->publishes([
            __DIR__.'/../resources/assets/sass' => resource_path('sass'),
        ], 'usaepay.creditcard');

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/apvanlaan'),
        ], 'usaepay.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
