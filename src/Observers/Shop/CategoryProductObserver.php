<?php

namespace Crghome\Shop\Observers\Shop;

use Crghome\Shop\Models\Shop\CategoryProduct;

class CategoryProductObserver
{
    /**
     * Handle the CategoryProduct "created" event.
     *
     * @param  \Crghome\Shop\Models\Shop\CategoryProduct  $categoryProduct
     * @return void
     */
    public function created(CategoryProduct $categoryProduct)
    {
        // $categoryProduct->created_user_id = auth()->user()->id;
        // $categoryProduct->created_at = date('Y-m-d H:i:s');
    }

    public function saving(CategoryProduct $categoryProduct)
    {
    }

    /**
     * Handle the CategoryProduct "updated" event.
     *
     * @param  \Crghome\Shop\Models\Shop\CategoryProduct  $categoryProduct
     * @return void
     */
    public function updated(CategoryProduct $categoryProduct)
    {
        // $categoryProduct->updated_user_id = auth()->user()->id;
        // $categoryProduct->updated_at = date('Y-m-d H:i:s');
        // empty($categoryProduct->created_at) ? $categoryProduct->created_at = date('Y-m-d H:i:s') : false;
    }

    /**
     * Handle the CategoryProduct "deleted" event.
     *
     * @param  \Crghome\Shop\Models\Shop\CategoryProduct  $categoryProduct
     * @return void
     */
    public function deleted(CategoryProduct $categoryProduct)
    {
        //
    }

    /**
     * Handle the CategoryProduct "restored" event.
     *
     * @param  \Crghome\Shop\Models\Shop\CategoryProduct  $categoryProduct
     * @return void
     */
    public function restored(CategoryProduct $categoryProduct)
    {
        //
    }

    /**
     * Handle the CategoryProduct "force deleted" event.
     *
     * @param  \Crghome\Shop\Models\Shop\CategoryProduct  $categoryProduct
     * @return void
     */
    public function forceDeleted(CategoryProduct $categoryProduct)
    {
        //
    }
}
