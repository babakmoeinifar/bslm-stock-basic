<?php

namespace Bslm\Stock;

use Illuminate\Support\ServiceProvider;

class StockServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'stock');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'stock');
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'stock');
        $this->publishes([__DIR__ . '/config/config.php' => config_path('stock.php')]);
        $this->publishes([__DIR__ . '/Http/Notifications' => app_path('Notifications')]);
    }

    public function register()
    {

    }
}