<p align="center">
<a href="https://crghome.ru"><img src="https://crghome.ru/templates/crghome/images/logoHeader.svg" width="300" alt="crghome"></a>
</p>

<p align="center">
<a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="100"></a>
</p>

## INFO

An application that implements the work of the store on the Laravel framework. There are a number of unspoken dependencies:
1. Back dev
    - DataTable Ajax
    - App\Helpers\CropImages of crghome
    - App\Helpers\AlertFlush of crghome
2. Visual
    - layers **Keen v.5.0**
    - fragment **admin.fragments.subheader.subheader-general**
    - component **x-alert-flush-component**
    - component **x-keen.page-card-layout**
    - component **x-keen.page-card-tabs-layout**, **x-keen.page-card-tabs-content-layout**
    - component **x-form-component**, **x-keen.forms.input-component**

> You can redefine to suit your needs in the section **resources/view/vendor/crghome-shop/**

### Features
- [x] :+1: work categories in admin panel
- [x] :fist: work products in admin panel
- [ ] work on front side
- [ ] modules
- [ ] components

<hr>

## INSTAL

The package is not registered, so you need to add <code>composer.json</code>:
<pre>"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/crghome/laravel-shop"
    }
]</pre>

Then we perform the installation in the usual format:
<pre>composer require crghome/laravel-shop</pre>
Or Instal Dev Version:
<pre>composer require crghome/laravel-shop:dev-main</pre>

### Published
Published dependencies in console:
<pre>php artisan vendor:publish --provider="Crghome\Shop\Providers\ShopServiceProvider" --force</pre>
If no Tag error then Add to <code>config/app.php</code> in section <i>providers</i>:
<pre>Crghome\Shop\Providers\ShopServiceProvider::class</pre>
If error Class "Crghome\Shop\Providers\ShopServiceProvider" not found to <code>composer.json</code> in section <i>autoload-dev -> psr-4</i>:
<pre>"Crghome\\Shop\\": "packages/crghome/shop/src/"</pre>

### Migration
Run migrate in console:
<pre>php artisan migrate</pre>

For test data (seeding):
<pre>php artisan db:seed --class="Database\Seeders\Crghome\Shop\DatabaseSeeder"</pre>

### Routing
Routes are set in the system:
- resource **cp.domain/crghome/shop/category**
- resource **cp.domain/crghome/shop/product**
To get url route in a view (other):
<pre>route(config('crghome-shop.prefix') . '.shop.product.index');</pre>
To redefine routes:
<pre>Route::resource('shop', Crghome\Shop\Http\Controllers\ShopController::class);</pre>
Or to redefine route with protected class:
<pre>Route::resource('shop', \App\Http\Controllers\Admin\Shop\ShopController::class);</pre>


## CONFIGURATION
### ASide menu
```
// variables
use Crghome\Shop\Services\ShopCategoryService;
use Crghome\Shop\Services\ShopProductService;
'shop' => (object)[
    'category' => (object)['new' => ShopCategoryService::getNewCategories(), 'upd' => ShopCategoryService::getUpdateCategories()],
    'product' => (object)['new' => ShopProductService::getNewProducts(), 'upd' => ShopProductService::getUpdateProducts()],
],

// section menu example
$arr[] = [
    'nameGroup' => 'МАГАЗИН',
    'menu' => [
        [
            'name' => config('crghome-shop.name', 'Магазин'),
            'icon' => 'fas fa-outdent',
            'isCurrent' => Str::startsWith((request()->route()->getName()??''), config('crghome-shop.prefix') . '.shop'),
            'isDir' => true,
            'boxSuccess' => ($counter->shop->category->new > 0 || $counter->shop->category->new > 0 ? '<i class="flaticon-add-circular-button text-white"></i>' : ''),
            'boxInfo' => ($counter->shop->category->upd > 0 || $counter->shop->category->upd > 0 ? '<i class="flaticon-edit text-white"></i>' : ''),
            'child' => [
                [
                    'name' => config('crghome-shop.name', 'Магазин'),
                    'icon' =>'fas fa-dumpster-fire',
                    'href' => route(config('crghome-shop.prefix') . '.shop.index'),
                    'isCurrent' => Str::startsWith((request()->route()->getName()??''), config('crghome-shop.prefix') . '.shop.index'),
                    'isDir' => false,
                    'child' => [],
                ],[
                    'name' => 'Категории',
                    'icon' =>'fas fa-dumpster-fire',
                    'href' => route(config('crghome-shop.prefix') . '.shop.category.index'),
                    'isCurrent' => Str::startsWith((request()->route()->getName()??''), config('crghome-shop.prefix') . '.shop.category'),
                    'isDir' => false,
                    'boxSuccess' => $counter->shop->category->new > 0 ? '+' . $counter->shop->category->new : '',
                    'boxInfo' => $counter->shop->category->upd > 0 ? '`' . $counter->shop->category->upd : '',
                    'child' => [],
                ],[
                    'name' => 'Продукты',
                    'icon' =>'fab fa-product-hunt',
                    'href' => route(config('crghome-shop.prefix') . '.shop.product.index'),
                    'isCurrent' => Str::startsWith((request()->route()->getName()??''), config('crghome-shop.prefix') . '.shop.product'),
                    'isDir' => false,
                    'boxSuccess' => $counter->shop->product->new > 0 ? '+' . $counter->shop->product->new : '',
                    'boxInfo' => $counter->shop->product->upd > 0 ? '`' . $counter->shop->product->upd : '',
                    'child' => [],
                ]
            ],
        ],
    ],
]
```
