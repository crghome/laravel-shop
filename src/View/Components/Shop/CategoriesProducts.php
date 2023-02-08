<?php

namespace Crghome\Shop\View\Components\Shop;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class CategoriesProducts extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ?Collection $collectCategories = null, 
        public Int $idServicePage = 0
    )
    {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('crghome-shop::front.components.categories-products');
    }
}
