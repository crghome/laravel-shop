<?php

namespace Crghome\Shop\View\Components\Shop;

use Crghome\Shop\Models\Shop\Category;
use Crghome\Shop\Services\ShopService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class CategoryProductsComponent extends Component
{
    /**
     * @param Int|NULL $idCategory
     * @param ?Collection $collectProducts
     * @return void
     */
    public function __construct(
        public Int|NULL $idCategory = null,
        public ?Collection $collectProducts = null
    )
    {
        if(!empty($idCategory)){
            $this->collectProducts = ShopService::getProducts($idCategory);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('crghome-shop::front.components.category-products-component');
    }
}
