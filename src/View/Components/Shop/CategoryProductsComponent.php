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
     * @param Collection|NULL $collectProducts
     * @param Bool $recursive --idCat must be
     * @return void
     */
    public function __construct(
        public Int|NULL $idCategory = null,
        public Collection|NULL $collectProducts = null,
        public Bool $recursive = false
    )
    {
        if(!empty($idCategory)){
            $this->collectProducts = ShopService::getProducts($idCategory, $recursive);
        } elseif($collectProducts === null){
            $this->collectProducts = ShopService::getProducts($idCategory, $recursive);
        }
        // dump($idCategory, $collectProducts, $this->collectProducts);
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
