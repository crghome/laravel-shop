<?php

namespace Crghome\Shop\Http\Controllers\Front;

use Crghome\Shop\Http\Controllers\Front\Controller;
use Crghome\Shop\Models\Shop\Category;
use Crghome\Shop\Models\Shop\Product;
use Crghome\Shop\Services\ShopService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function main(Request $request)
    {
        $title = $meta = $ogimage = '';
        $data = (object)[
            'categories' => ShopService::getCategories(),
            'products' => ShopService::getProducts(),
        ];
        // extract(ShopService::getBasisContentPage(null, null, true), EXTR_OVERWRITE);
        // $ogimage = ShopService::getOgImage($article);
        return view('crghome-shop::front.main', compact('data', 'title', 'meta', 'ogimage'));
    }

    public function category(Request $request, Category $category)
    {
        $title = $meta = $ogimage = '';
        // dd($category);
        $data = (object)[
            'category' => $category,
            'categories' => $category->categories,
            'products' => $category->products,
        ];
        // extract(ShopService::getBasisContentPage(null, null, true), EXTR_OVERWRITE);
        // $ogimage = ShopService::getOgImage($article);
        return view('crghome-shop::front.category', compact('data', 'title', 'meta', 'ogimage'));
    }

    public function product(Request $request, Product $product)
    {
        $title = $meta = $ogimage = '';
        // dd($product->categories());
        $data = (object)[
            'product' => $product,
            'categories' => $product->categories,
            // 'products' => $category->products,
        ];
        // extract(ShopService::getBasisContentPage(null, null, true), EXTR_OVERWRITE);
        // $ogimage = ShopService::getOgImage($article);
        return view('crghome-shop::front.product', compact('data', 'title', 'meta', 'ogimage'));
    }
}