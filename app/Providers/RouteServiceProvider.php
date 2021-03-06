<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
            // API routes versions definition
            $this->apiRoutes('v1');

            // Internal API routes protected by Laravel Passport Client Credentials
            $this->clientRoutes();

            // Laravel default web routing
            $this->webRoutes();
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     * 
     * @return void
     */
    protected function clientRoutes()
    {
        Route::prefix('api/client')
            ->middleware(['api', 'client'])
            ->namespace($this->namespace)
            ->group(base_path('routes/api/client.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     * 
     * @param string $version
     * @return void
     */
    protected function apiRoutes($version)
    {
        Route::prefix(sprintf('api/%s', $version))
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path(sprintf('routes/api/%s.php', $version)));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function webRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }
}
