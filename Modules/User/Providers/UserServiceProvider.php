<?php

namespace Modules\User\Providers;

use Modules\User\Admin\RoleTabs;
use Modules\User\Admin\UserTabs;
use Modules\User\Guards\Sentinel;
use Modules\User\Admin\ProfileTabs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Modules\Support\Traits\AddsAsset;
use Illuminate\Support\ServiceProvider;
use Modules\Support\Traits\LoadsConfig;
use Modules\Admin\Ui\Facades\TabManager;
use Modules\User\Contracts\Authentication;
use Modules\User\Sentinel\SentinelAuthentication;
use Modules\Admin\Http\ViewComposers\AssetsComposer;
use Modules\User\Http\ViewComposers\CurrentUserComposer;

class UserServiceProvider extends ServiceProvider
{
    use AddsAsset, LoadsConfig;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! config('app.installed')) {
            return;
        }

        TabManager::register('users', UserTabs::class);
        TabManager::register('roles', RoleTabs::class);
        TabManager::register('profile', ProfileTabs::class);

        View::composer('*', CurrentUserComposer::class);
        View::composer('user::admin.auth.layout', AssetsComposer::class);
        View::composer('user::vendor.auth.layout', AssetsComposer::class);

        $this->addAdminPanelAssets('admin.(login|reset).*', ['vendor.login.css', 'vendor.login.js']);
        $this->addAdminPanelAssets('vendor.(login|reset).*', ['vendor.login.css', 'vendor.login.js']);
        $this->addAdminPanelAssets('admin.(users|roles).(create|edit)', ['admin.user.css', 'admin.user.js']);

        $this->registerSentinelGuard();
        $this->registerBladeDirectives();
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

        $this->app->bind(Authentication::class, SentinelAuthentication::class);
    }

    /**
     * Register sentinel guard.
     *
     * @return void
     */
    private function registerSentinelGuard()
    {
        Auth::extend('sentinel', function () {
            return new Sentinel;
        });
    }

    /**
     * Register blade directives.
     *
     * @return void
     */
    private function registerBladeDirectives()
    {
        Blade::directive('hasAccess', function ($permissions) {
            return "<?php if (\$currentUser->hasAccess($permissions)) : ?>";
        });

        Blade::directive('endHasAccess', function () {
            return '<?php endif; ?>';
        });

        Blade::directive('hasAnyAccess', function ($permissions) {
            return "<?php if (\$currentUser->hasAnyAccess($permissions)) : ?>";
        });

        Blade::directive('endHasAnyAccess', function () {
            return '<?php endif; ?>';
        });
    }
}
