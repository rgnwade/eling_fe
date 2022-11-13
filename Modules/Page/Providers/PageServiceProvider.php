<?php

namespace Modules\Page\Providers;

use Modules\Page\Admin\PageTabs;
use Illuminate\Support\ServiceProvider;
use Modules\Support\Traits\LoadsConfig;
use Modules\Support\Traits\AddsAsset;
use Modules\Admin\Ui\Facades\TabManager;

class PageServiceProvider extends ServiceProvider
{
    use LoadsConfig;
    use AddsAsset;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TabManager::register('pages', PageTabs::class);
        $this->addAdminPanelAssets('admin.pages.(create|edit)',[ 'admin.media.css', 'admin.media.js']);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadConfigs('permissions.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
