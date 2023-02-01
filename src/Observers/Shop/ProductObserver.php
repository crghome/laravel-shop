<?php

namespace Crghome\Shop\Observers\Shop;

use Crghome\Shop\Models\Shop\Product;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \Crghome\Shop\Models\Shop\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \Crghome\Shop\Models\Shop\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \Crghome\Shop\Models\Shop\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \Crghome\Shop\Models\Shop\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \Crghome\Shop\Models\Shop\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
