<?php

namespace Crghome\Shop\View\Components\Shop;

use Crghome\Shop\Models\Shop\Category;
use Crghome\Shop\Services\ShopService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class CategoriesOfProductComponent extends Component
{
    /**
     * @param Int|NULL $idProduct
     * @param ?Collection $collectCategories
     * @return void
     */
    public function __construct(
        public Int|NULL $idProduct = null,
        public ?Collection $collectCategories = null
    )
    {
        if(!empty($idProduct)){
            $this->collectCategories = ShopService::getCategoriesOfProduct(idProd: $idProduct);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('crghome-shop::front.components.categories-of-product-component');
    }
}
