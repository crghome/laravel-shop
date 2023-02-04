<?php

namespace Crghome\Shop\Providers;

use Illuminate\Support\ServiceProvider;
use Crghome\Shop\Console\Commands\ShopCommand;
use Crghome\Shop\Models\Shop\Category;
use Crghome\Shop\Models\Shop\CategoryProduct;
use Crghome\Shop\Models\Shop\Product;
use Illuminate\Support\Facades\Route;

class ShopServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/crghome-shop.php', 'crghome-shop');

        $this->registerResponseBindings();
    }

    public function registerResponseBindings(){
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'crghome-shop');

        // $this->app->singleton(FailedPasswordConfirmationResponseContract::class, FailedPasswordConfirmationResponse::class);
    }

    public function boot()
    {
        $this->configurePublishing();
        $this->configureRoutes();

        // observers
        Category::observe(\Crghome\Shop\Observers\Shop\CategoryObserver::class);
        Product::observe(\Crghome\Shop\Observers\Shop\ProductObserver::class);
        CategoryProduct::observe(\Crghome\Shop\Observers\Shop\CategoryProductObserver::class);
    }

    /**
     * Configure the publishable resources offered by the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
            $this->publishes([
                __DIR__.'/../../database/seeders/' => database_path('seeders')
            ], 'crghome-seeders');
            
            $this->publishes([
                __DIR__ . '/../../config/crghome-shop.php' => config_path('crghome-shop.php'),
            ]);

            $this->publishes([
                __DIR__.'/../../database/migrations' => database_path('migrations'),
            ], 'crghome-shop-migrations');

            // $this->commands([
            //     ShopCommand::class,
            // ]);

            // $this->publishes([
            //     __DIR__.'/../../stubs/ShopController.php' => app_path('Http/Controllers/Admin/Shop/ShopController.php'),
            // ]);

            // $this->publishes([
            //     __DIR__ . '/../resources/views' => resource_path('views/vendor/shop'),
            // ], 'crghome-views');
        }
    }

    /**
     * Configure the routes offered by the application.
     *
     * @return void
     */
    protected function configureRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        Route::group([
            'namespace' => 'Crghome\Shop\Http\Controllers',
            'domain' => config('crghome-shop.domain', null),
            'prefix' => config('crghome-shop.prefix'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../../routes/routes.php');
        });
    }
}