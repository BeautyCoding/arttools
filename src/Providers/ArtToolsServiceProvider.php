<?php

namespace BeautyCoding\ArtTools\Providers;

use BeautyCoding\ArtTools\Console\Commands\MakeBeautyControllerCommand;
use BeautyCoding\ArtTools\Console\Commands\MakeBeautyModelCommand;
use BeautyCoding\ArtTools\Console\Commands\MakeBeautyRequestCommand;
use Illuminate\Support\ServiceProvider;

class ArtToolsServiceProvider extends ServiceProvider
{
    protected $commands = [
        MakeBeautyControllerCommand::class,
        MakeBeautyRequestCommand::class,
        MakeBeautyModelCommand::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../resource/stubs' => base_path('resources/vendor/stubs'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
