<?php

namespace NikosIoannidis\Softone;
use Illuminate\Support\ServiceProvider;

class SoftoneServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register package services
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/softone.php' => config_path('softone.php'),
        ]);
    }
}
