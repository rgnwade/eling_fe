<?php

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

abstract class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::group([
            'namespace' => $this->namespace,
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => ['localize', 'locale_session_redirect', 'localization_redirect', 'web'],
        ], function () {
            $this->adminRoutes();
            $this->vendorRoutes();
            $this->publicRoutes();
        });
    }

    /**
     * Define the admin routes.
     *
     * @return void
     */
    private function adminRoutes()
    {
        if (! method_exists($this, 'admin')) {
            return;
        }

        Route::group([
            'namespace' => 'Admin',
            'domain' => $this->subdomainUrl(config('app.prefix_admin_url')),
            'middleware' => ['admin','2fa'],
        ], function () {
            require $this->admin();
        });

    }

    /**
     * Define the public routes.
     *
     * @return void
     */
    private function publicRoutes()
    {
        if (method_exists($this, 'public')) {
            require $this->public();
        }
    }

    /**
     * Define the seller routes.
     *
     * @return void
     */
    private function vendorRoutes()
    {
        if (! method_exists($this, 'vendor')) {
            return;
        }
        Route::group([
            'namespace' => 'Vendor',
            'domain' => $this->subdomainUrl(config('app.prefix_vendor_url')),
            'middleware' => ['vendor','2fa'],
        ], function () {
            require $this->vendor();
        });
    }

    private function subdomainUrl($prefix)
    {
        return  $prefix.'.'.str_replace(['https', 'http',':', '/', 'www.'], '', config('app.url'));
    }
}
