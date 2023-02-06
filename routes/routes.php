<?php
/**
 * PRIVATE
 */
use Illuminate\Support\Facades\Route;

Route::domain(env('APP_ADMIN_PREFIX', config('crghome-shop.admin_prefix', 'cp')) . '.'  . env('APP_DOMAIN', config('crghome-shop.domain', 'localhost')))
->middleware(['web', 'auth', 'role:' . config('crghome-shop.middleware_role_string', 'admin')])
->name(config('crghome-shop.prefix') . '.')
->group(function () {

    $enableViews = config('crghome-shop.views', true);
    
    Route::prefix('resource')->name('resource.')->group(function () {
        Route::prefix('datatable')->name('datatable.')->group(function () {
            Route::prefix('shop')->name('shop.')->group(function () {
                Route::get('category', [Crghome\Shop\Http\Controllers\Api\Datatable\Shop\CategoryDatatableController::class, 'getData'])->name('category');
                Route::get('product', [Crghome\Shop\Http\Controllers\Api\Datatable\Shop\ProductDatatableController::class, 'getData'])->name('product');
            });
        });
    });

    Route::prefix('shop')->name('shop.')->group(function () {
        Route::get('/', [Crghome\Shop\Http\Controllers\Admin\ShopController::class, 'index'])->name('index');
        Route::resource('category', Crghome\Shop\Http\Controllers\Admin\ShopCategoryController::class);
        Route::resource('product', Crghome\Shop\Http\Controllers\Admin\ShopProductController::class);
    });

});