<?php

namespace Modules\Attribute\Providers;

use Modules\Support\Traits\AddsAsset;
use Illuminate\Support\ServiceProvider;
use Modules\Support\Traits\LoadsConfig;
use Modules\Admin\Ui\Facades\TabManager;
use Modules\Attribute\Admin\AttributeTabs;
use Modules\Attribute\Admin\AttributeSetTabs;
use Modules\Attribute\Admin\ProductTabsExtender;

class AttributeServiceProvider extends ServiceProvider
{
    use AddsAsset, LoadsConfig;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        TabManager::register('attributes', AttributeTabs::class);
        TabManager::register('attribute_sets', AttributeSetTabs::class);
        TabManager::extend('products', ProductTabsExtender::class);
        TabManager::extend('products_vendor', ProductTabsExtender::class);


        $this->addAdminPanelAssets('admin.(attributes|products).(create|edit)', ['admin.attribute.css', 'admin.attribute.js']);
        $this->addAdminPanelAssets('vendor.products.(create|edit)', ['admin.attribute.css', 'admin.attribute.js']);
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
