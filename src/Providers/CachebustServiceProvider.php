<?php
/**
 * This file is part of Laravel Cachebust
 *
 * @copyright Copyright (c) Ian Caunce
 * @author    Ian Caunce <iancauncedevelopment@gmail.com>
 * @license   MIT <http://opensource.org/licenses/MIT>
 */

namespace IanCaunce\Cachebust\Providers;

use IanCaunce\Cachebust\Cachebust;
use Illuminate\Support\ServiceProvider;

class CachebustServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('cachebust.php'),
        ]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'cachebust');

        $this->app->bind('IanCaunce\Cachebust\Cachebust', function ($app) {
            return new Cachebust(config('cachebust', []));
        });

    }
}
