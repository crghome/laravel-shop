<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://crghome.ru"><img src="https://crghome.ru/templates/crghome/images/logoHeader.svg" alt="crghome"></a>
</p>

## INFO

<p>Shop - Shop for Laravel 9+</p>

### INSTAL

<p>Add to <code>composer.json</code>:</p>
<p><pre>"repositories": [
    {
        "type": "vcs",
        "url": "https://gitlab.com/crghome/laravel-shop"
    }
]</pre></p>

<p>next:</p>
<p><pre>composer require crghome/laravel-shop</pre></p>
<p>Instal Dev Version:</p>
<p><pre>composer require crghome/laravel-shop:dev-main</pre></p>

<p>Published dependencies in console:</p>
<p><pre>php artisan vendor:publish --provider="Crghome\Shop\Providers\ShopServiceProvider" --force</pre></p>
<p>If no Tag error then Add to <code>config/app.php</code> in section <i>providers</i>:</p>
<p><pre>Crghome\Shop\Providers\ShopServiceProvider::class</pre></p>
<p>If error Class "Crghome\Shop\Providers\ShopServiceProvider" not found to <code>composer.json</code> in section <i>autoload-dev -> psr-4</i>:</p>
<p><pre>"Crghome\\Shop\\": "packages/crghome/shop/src/"</pre></p>

<p>Run migrate in console:</p>
<p><pre>php artisan migrate</pre></p>

<p>For test data (seeding):</p>
<p><pre>php artisan db:seed --class="Database\Seeders\Crghome\Shop\DatabaseSeeder"</pre></p>

<p>Add url route:</p>
<p><pre>Route::resource('shop', Crghome\Shop\Http\Controllers\ShopController::class);</pre></p>

<p>And route this:</p>
<p><pre>route('shop.index');</pre></p>
<p>Or route with protected:</p>
<p><pre>Route::resource('shop', \App\Http\Controllers\Admin\Shop\ShopController::class);</pre></p>
