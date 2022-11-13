<?php

namespace Modules\Company\Providers;

use Modules\Company\Admin\CompanyTabs;
use Illuminate\Support\ServiceProvider;
use Modules\Support\Traits\LoadsConfig;
use Modules\Support\Traits\AddsAsset;
use Modules\Admin\Ui\Facades\TabManager;


class CompanyServiceProvider extends ServiceProvider
{
    use LoadsConfig, AddsAsset;


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        TabManager::register('companies', CompanyTabs::class);

        $this->addAdminPanelAssets('admin.companies.(create|edit)', [
            'admin.media.css', 'admin.media.js'
        ]);

        $this->addAdminPanelAssets('vendor.companies.edit', [
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
        $this->loadConfigs('permissions.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
