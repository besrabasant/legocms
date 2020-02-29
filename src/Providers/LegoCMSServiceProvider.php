<?php

namespace LegoCMS\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Astrotomic\Translatable\TranslatableServiceProvider;
use LegoCMS\Commands\CreateSuperAdmin;
use LegoCMS\Exceptions\LegoCMSExceptionHandler;
use LegoCMS\Models\User;
use LegoCMS\Services\LegoCMS;
use LegoCMS\Testing\TestServiceProvider;

/**
 * Class LegoCMSServiceProvider
 *
 * @category ServiceProviders
 * @package  LegoCMS\Providers
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Providers/LegoCMSServiceProvider.php
 */
class LegoCMSServiceProvider extends ServiceProvider
{
    protected $serviceProviders = [
        LegoSetsServiceProvider::class,
        RouteServiceProvider::class,
        ViewServiceProvider::class,
        TranslatableServiceProvider::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindServices();

        $this->bindExceptionHandler();

        $this->registerServiceProviders();

        $this->registerConfigurations();

        if ($this->app->environment('testing')) {
            $this->app->register(TestServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->requireHelpers();

        $this->registerConsoleCommands();

        $this->registerMigrations();

        $this->registersTranslationConfig();

        $this->publishConfigurations();

        $this->publishAssets();

        $this->loadAndPublishCMSTranslations();
    }


    /**
     * Requires Package Helpers.
     *
     * @return  void
     */
    private function requireHelpers()
    {
        require_once __DIR__ . "/../Helpers/system_helpers.php";
        require_once __DIR__ . "/../Helpers/i18n_helpers.php";
        require_once __DIR__ . "/../Helpers/migration_helpers.php";
        require_once __DIR__ . "/../Helpers/route_helpers.php";
    }

    /**
     * Binds Services.
     *
     * @return void
     */
    protected function bindServices()
    {
        $this->app->singleton(LegoCMS::class);
        $this->app->alias(LegoCMS::class, 'legocms');
    }

    /**
     * Binds Exception Handler
     *
     * @return void
     */
    protected function bindExceptionHandler()
    {
        if (\config('legocms.bind_exception_handler', true)) {
            $this->app->singleton(
                ExceptionHandler::class,
                LegoCMSExceptionHandler::class
            );
        }
    }

    /**
     * Registers console commands.
     *
     * @return void
     */
    protected function registerConsoleCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                [CreateSuperAdmin::class]
            );
        }
    }

    /**
     * Loads Migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }


    /**
     * Register package configurations.
     *
     * @return void
     */
    protected function registerConfigurations()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/legocms.php', 'legocms');
        $this->mergeConfigFrom(__DIR__ . '/../../config/legosets.php', 'legocms.legosets');
        $this->mergeConfigFrom(__DIR__ . '/../../config/legocms-navigation.php', 'legocms.navigation');
        $this->mergeConfigFrom(__DIR__ . '/../../config/legocms-modules.php', 'legocms.modules');
        $this->mergeConfigFrom(__DIR__ . '/../../config/enabled.php', 'legocms.enabled');
    }

    /**
     * Publishes Package configurations.
     *
     * @return void
     */
    protected function publishConfigurations()
    {
        \config(
            ['auth.providers.legocms_users' => [
                'driver' => 'eloquent',
                'model' => User::class,
            ]]
        );

        \config(
            ['auth.guards.legocms_users' => [
                'driver' => 'session',
                'provider' => 'legocms_users',
            ]]
        );

        \config(
            ['auth.passwords.legocms_users' => [
                'provider' => 'legocms_users',
                'table' => config('legocms.password_resets_table', 'legocms_password_resets'),
                'expire' => 60,
                'throttle' => 60,
            ]]
        );

        \config(['debugbar.enabled' => \config("app.debug")]);

        $this->publishes(
            [
                __DIR__ . '/../../config/legocms.php' => \config_path('legocms.php'),
            ],
            'config'
        );
    }

    /**
     * Publishes package assets.
     *
     * @return void
     */
    protected function publishAssets()
    {
        $this->publishes(
            [
                __DIR__ . '/../../public' => \public_path(),
            ],
            'assets'
        );
    }

    /**
     * Registers Translations config.
     *
     * @return void
     */
    protected function registersTranslationConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/translatable.php', 'translatable');

        $this->publishes([
            __DIR__ . '/../../config/translatable.php' => \config_path('translatable.php')
        ], 'translatable');
    }

    /**
     * Registers CMS Translations.
     *
     * @return void
     */
    protected function loadAndPublishCMSTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'legocms');
        $this->publishes([__DIR__ . '/../../resources/lang' => \resource_path('lang/vendor/legocms')]);
    }

    /**
     * Registers Service Providers.
     *
     * @return void
     */
    protected function registerServiceProviders()
    {
        foreach ($this->serviceProviders as $serviceProvider) {
            $this->app->register($serviceProvider);
        }
    }
}
