<?php
namespace Crghome\Shop\Services;

use App\Helpers\CropImages;
use Crghome\Shop\Models\ImageModel;
use Crghome\Shop\Models\Shop\Category;
use Crghome\Shop\Models\Shop\Product;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ShopService{
    /** Get OG:IMAGE
     * @param Object $obj
     * @return String
     */
    public static function getOgImage(Object $obj){
        $ogImg = '';
        $images = $obj->images;
        $ogImgFull = !empty($images->prev) ? $images->prev : $images?->full;
        if(!empty($ogImgFull) && file_exists($_SERVER['DOCUMENT_ROOT'] . $ogImgFull)){
            $cropImages = new CropImages();
            $ogImg = !empty($ogImgFull) && file_exists($_SERVER['DOCUMENT_ROOT'] . $ogImgFull) ? $cropImages->cropImages($ogImgFull, '/cache/og-image', 300, 70) : config('app.ogimage');
        }

        return $ogImg;
    }

    /** Get Title and Meta isset
     * @param String $path = null, String $alias = null, $show = false
     * @return Array
     */
    public static function getBasisContentPage(String $path = null, String $alias = null, $show = false){
        $title = $meta = $article = $ogimage = '';
        $article = self::getArticleContent($path, $alias);
        //dd($article);
        if($article){
            $newDate = new \DateTime();
            $dateArticleBegin = \DateTime::createFromFormat('Y-m-d H:i:s', $article->dateBeginPub??date('Y-m-d H:i:s'));
            $dateArticleEnd = $article->dateEndPub??null;
            $dateArticleEnd ? $dateArticleEnd = \DateTime::createFromFormat('Y-m-d H:i:s', $article->dateEndPub) : false;
            if(($dateArticleBegin && $dateArticleBegin <= $newDate) && (!$dateArticleEnd || ($dateArticleEnd && $dateArticleEnd >= $newDate))){
                $title = self::getArticleTitle($article);
                $meta = self::getArticleMeta($article);
                $ogimage = self::getArticleOgImage($article);
                $show && $article ? self::setArticleContentShowIncrement($article->articleContents[0]->id??0) : false;
            } else {
                abort(404, 'Запрошенная страница не найдена');
            }
        } else {
            abort(404, 'Запрошенная страница не найдена');
        }

        return ['article' => $article, 'title' => $title, 'meta' => $meta, 'ogimage' => $ogimage];
    }

    /** Get Categories Eloquent
     * @param Int|Null $idCat
     * @return Eloquent
     */
    public static function getCategories(Int|Null $idCat = null){
        $newDate = new \DateTime();
        $category = Category::where('hide', false);
        $category = $idCat === null ? $category->whereNull('category_id') : $category->where('category_id', $idCat);
        $category = $category->where(function($query) use ($newDate){
                $query->whereNull('dateBeginPub')->orWhere('dateBeginPub', '<=', $newDate);
            })
            ->where(function($query) use ($newDate){
                $query->whereNull('dateEndPub')->orWhere('dateEndPub', '>=', $newDate);
            })
            ->get();
        return $category;
    }

    /** Get Categories Eloquent of Product
     * @param ?Product $product
     * @param Int|null $idProd
     * @return Eloquent
     */
    public static function getCategoriesOfProduct(?Product $product = null, Int|null $idProd = null){
        $category = [];
        $newDate = new \DateTime();
        if(!empty($idProd)) $product = Product::find($idProd);
        if(!empty($product)){
            $category = $product->categories()->where('hide', false);
            $category = $category->where(function($query) use ($newDate){
                    $query->whereNull('dateBeginPub')->orWhere('dateBeginPub', '<=', $newDate);
                })
                ->where(function($query) use ($newDate){
                    $query->whereNull('dateEndPub')->orWhere('dateEndPub', '>=', $newDate);
                })
                ->get();
        }
        return $category;
    }

    /** Get Products Eloquent
     * @param Int|Null $idCat
     * @return Eloquent
     */
    public static function getProducts(Int|Null $idCat = null){
        $newDate = new \DateTime();
        $products = Product::where('hide', false);
        $products = $idCat === null 
            ? $products->doesntHave('categories') 
            : $products->whereRelation('categories', config('crghome-shop.db.tables.categories').'.id', $idCat);
        $products = $products->where(function($query) use ($newDate){
                $query->whereNull('dateBeginPub')->orWhere('dateBeginPub', '<=', $newDate);
            })
            ->where(function($query) use ($newDate){
                $query->whereNull('dateEndPub')->orWhere('dateEndPub', '>=', $newDate);
            })
            ->get();
        return $products;
    }

}