<?php

namespace Simmatrix\PaymentProcessor\Providers;
use Illuminate\Support\ServiceProvider;

class PaymentProcessorServiceProvider extends ServiceProvider
{
    protected $templates = [];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $source_config = __DIR__ . '/../../config/cos_processor.php';
        $this->publishes([
            $source_config => base_path('config/cos_processor.php')
        ]);

        // $this->loadViewsFrom(__DIR__ . '/../views', 'cos_processor');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $source_config = __DIR__ . '/../../config/cos_processor.php';
        $this->mergeConfigFrom($source_config, 'cos_processor');
    }
}
