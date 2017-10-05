<?php

namespace Simmatrix\PaymentProcessor\Providers;

use Illuminate\Support\ServiceProvider;

class PaymentProcessorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this -> publishes([
            __DIR__ . '/../../config/payment_processor.php' => base_path('config/payment_processor.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this -> mergeConfigFrom( __DIR__ .'./../../config/payment_processor.php', 'bank_processor' );
    }
}
