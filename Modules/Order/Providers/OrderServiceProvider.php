<?php

namespace Modules\Order\Providers;

use Modules\Support\Traits\AddsAsset;
use Illuminate\Support\ServiceProvider;
use Modules\Support\Traits\LoadsConfig;

class OrderServiceProvider extends ServiceProvider
{
    use AddsAsset, LoadsConfig;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->addAdminPanelAssets('admin.orders.show', ['admin.order.css', 'admin.order.js']);

        $this->addAdminPanelAssets('vendor.orders.show', ['admin.order.css', 'admin.order.js']);
        $this->addAdminPanelAssets('admin.orders_vendor.show', ['admin.order.css', 'admin.order.js', 'admin.media.css', 'admin.media.js']);
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
    }
}
