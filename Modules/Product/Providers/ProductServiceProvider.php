<?php

namespace Modules\Product\Providers;

use Modules\Product\RecentlyViewed;
use Modules\Support\Traits\AddsAsset;
use Modules\Product\Admin\ProductTabs;
use Modules\Product\Admin\ProductVendorTabs;
use Illuminate\Support\ServiceProvider;
use Modules\Support\Traits\LoadsConfig;
use Modules\Admin\Ui\Facades\TabManager;

class ProductServiceProvider extends ServiceProvider
{
    use AddsAsset, LoadsConfig;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TabManager::register('products', ProductTabs::class);
        TabManager::register('products_vendor', ProductVendorTabs::class);

        $this->addAdminPanelAssets('admin.products.(create|edit)', [
            'admin.media.css', 'admin.media.js', 'admin.product.css', 'admin.product.js',
        ]);

        $this->addAdminPanelAssets('vendor.products.(create|edit)', [
            'vendor.media.css', 'vendor.media.js',
        ]);

        $this->addAdminPanelAssets('vendor.products.(create|edit)', [
            'vendor.media.css', 'vendor.media.js',
        ]);

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadConfigs(['assets.php', 'permissions.php']);
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->app->singleton(RecentlyViewed::class, function ($app) {
            return new RecentlyViewed(
                $app['session'],
                $app['events'],
                'compare',
                session()->getId() . '_recently_viewed',
                config('modules.compare.config')
            );
        });

        $this->app->alias(RecentlyViewed::class, 'recently_viewed');
    }
}
