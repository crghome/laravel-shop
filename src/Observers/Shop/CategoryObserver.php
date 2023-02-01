<?php

namespace Crghome\Shop\Observers\Shop;

use Crghome\Shop\Models\Shop\Category;
use Crghome\Shop\Services\ShopCategoryService;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     *
     * @param  \Crghome\Shop\Models\Shop\Category  $category
     * @return void
     */
    public function creating(Category $category)
    {
        $category['path'] = !empty($category['category_id']) ? ShopCategoryService::makePath($category['category_id']) . '/' . $category['alias'] : $category['alias'];
    }
    public function created(Category $category)
    {
        //
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \Crghome\Shop\Models\Shop\Category  $category
     * @return void
     */
    public function updating(Category $category)
    {
        $category['path'] = !empty($category['category_id']) ? ShopCategoryService::makePath($category['category_id']) . '/' . $category['alias'] : $category['alias'];
    }
    public function updated(Category $category)
    {
        //
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \Crghome\Shop\Models\Shop\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        //
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \Crghome\Shop\Models\Shop\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \Crghome\Shop\Models\Shop\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
