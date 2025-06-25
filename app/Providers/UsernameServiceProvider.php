<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\ServiceProvider;

class UsernameServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the custom user provider
        $this->app->singleton('auth.provider.username', function ($app) {
            return new UsernameUserProvider($app['hash'], config('auth.providers.users.model'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app['auth']->provider('eloquent', function ($app, array $config) {
            return new UsernameUserProvider($app['hash'], $config['model']);
        });
    }
}
