<?php
namespace Crghome\Shop\Services;

use App\Helpers\CropImages;
use Carbon\Carbon;
use Crghome\Shop\Models\Shop\Product;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ShopProductService{

    /**
     * @return Int
     */
    public static function getNewProducts(){
        return Product::where('created_at', '>=', Carbon::now()->subDay(7))->count();
    }

    /**
     * @return Int
     */
    public static function getUpdateProducts(){
        return Product::where('updated_at', '>=', Carbon::now()->subDay(7))->count();
    }

    // public static function getSlug($id){
    //     $slug = '';
    //     $thisLocale = LocaleService::getLocale(true);
    //     $repoCache = 'slug.cat.'.$thisLocale.'.'.$id;
    //     //Cache::clear($repoCache);
    //     $slug = Cache::get($repoCache, '');
    //     if(empty($slug)){
    //         $category = Category::find($id);
    //         $slug = $category ? route('site.category', ['category' => $category->path], false) : '';
    //         Cache::put($repoCache, $slug);
    //     }

    //     return $slug;
    // }

    // public static function getCategoryTitle($category){
    //     $title = '';
    //     if(!empty($category) && isset($category->categoryContents[0]->title) && !empty($category->categoryContents[0]->title)){
    //         $title = $category->categoryContents[0]->title;
    //     } elseif(!empty($category) && isset($category->categoryContents[0]->name) && !empty($category->categoryContents[0]->name)){
    //         $title = $category->categoryContents[0]->name;
    //     } else {
    //         $title = config('app.title');
    //     }

    //     return $title;
    // }

    // public static function getCategoryMeta($category){
    //     $meta = '';
    //     if(!empty($category) && isset($category->categoryContents[0]->meta) && !empty($category->categoryContents[0]->meta)){
    //         $meta = MetaModel::getMeta($category->categoryContents[0]->meta??'');
    //     } else {
    //         $meta = (object)['description' => config('app.title'), 'keywords' => config('app.title')];
    //     }

    //     return $meta;
    // }

    public static function getProductOgImage($product){
        $ogImg = '';
        $images = ImageModel::getImage($product->images??'');
        $ogImgFull = !empty($images->prev) ? $images->prev : $images->full;
        if(!empty($ogImgFull) && file_exists($_SERVER['DOCUMENT_ROOT'] . $ogImgFull)){
            $cropImages = new CropImages();
            $ogImg = !empty($ogImgFull) && file_exists($_SERVER['DOCUMENT_ROOT'] . $ogImgFull) ? $cropImages->cropImages($ogImgFull, '/cache/og-image', 300, 70) : config('app.ogimage');
        }

        return $ogImg;
    }

    // public static function getBasisContentPage(String $path = null, $show = false){
    //     $title = $meta = $ogimage = '';
    //     $category = self::getCategoryContent($path);
    //     if($category){
    //         $newDate = new \DateTime();
    //         $dateCategoryBegin = \DateTime::createFromFormat('Y-m-d H:i:s', $category->dateBeginPub??date('Y-m-d H:i:s'));
    //         $dateCategoryEnd = $category->dateEndPub??null;
    //         $dateCategoryEnd ? $dateCategoryEnd = \DateTime::createFromFormat('Y-m-d H:i:s', $category->dateEndPub) : false;
    //         if(($dateCategoryBegin && $dateCategoryBegin <= $newDate) && (!$dateCategoryEnd || ($dateCategoryEnd && $dateCategoryEnd >= $newDate))){
    //             $title = self::getCategoryTitle($category);
    //             $meta = self::getCategoryMeta($category);
    //             $ogimage = self::getCategoryOgImage($category);
    //             $show && $category ? self::setCategoryContentShowIncrement($category->categoryContents[0]->id??0) : false;
    //         } else {
    //             abort(404, 'Запрошенная страница не найдена');
    //         }
    //     } else {
    //         abort(404, 'Запрошенная страница не найдена');
    //     }
    //     //dd($title, $meta, $ogimage);

    //     return ['category' => $category, 'title' => $title, 'meta' => $meta, 'ogimage' => $ogimage];
    // }

    // public static function getCategoryContent(String $pathPage = null){
    //     $thisLang = LocaleService::getLocale(true);
    //     $newDate = new \DateTime();
    //     $catAlias = !empty($pathPage) ? self::getCatAliasFromPath($pathPage) : '';
    //     $pathArr = self::getPathArr($pathPage);
    //     $pathStr = $pathArr !== null ? implode('/', $pathArr) : null;
    //     $category = Category::with(['categoryContents' => function($query) use ($thisLang){ $query->whereIn('language_id', function($query) use ($thisLang){ $query->select('id')->from('languages')->where('locale', $thisLang); }); }])
    //     ->where('path', $pathStr)
    //     ->where('alias', $catAlias)
    //     ->first();
    //     //dd($category);
    //     return $category;
    // }

    // public static function setCategoryContentShowIncrement(Int $id){
    //     $categoryContent = CategoryContent::find($id);
    //     if($categoryContent){
    //         $categoryContent->views++;
    //         $categoryContent->save();
    //     }
    // }

    // public static function getChildCategories($idCat = null){
    //     $thisLang = LocaleService::getLocale(true);
    //     $newDate = new \DateTime();
    //     $categories = Category::select('categories.id', 'categories.category_id', 'categories.alias', 'categories.path', 'categories.name', 'categories.dateBeginPub', 'categories.dateEndPub', 'categories.hide', 'categories.order', 'categories.showPrevText', 'category_contents.name AS content_name', 'category_contents.title', 'category_contents.prevText', 'category_contents.fullText', 'category_contents.images', 'category_contents.meta')
    //     ->with('categoryContents')
    //     ->join('category_contents', 'categories.id', '=', 'category_contents.category_id')
    //     ->where('categories.category_id', $idCat)
    //     ->where(function($query) use ($newDate){
    //         $query->whereNull('dateBeginPub')->orWhere('dateBeginPub', '<=', $newDate);
    //     })
    //     ->where(function($query) use ($newDate){
    //         $query->whereNull('dateEndPub')->orWhere('dateEndPub', '>=', $newDate);
    //     })
    //     ->whereIn('category_contents.language_id', function($query) use ($thisLang){
    //         $query->select('id')->from('languages')->where('locale', $thisLang);
    //     })
    //     ->orderBy('order', 'ASC')
    //     ->orderBy('dateBeginPub', 'DESC')
    //     ->orderBy('category_contents.name', 'ASC')
    //     ->get();
    //     //dd($categories);
    //     return $categories;
    // }

    // public static function getChildArticles($idCat = null){
    //     $thisLang = LocaleService::getLocale(true);
    //     $newDate = new \DateTime();
    //     $articles = Article::with('articleContents')
    //     ->join('article_contents', 'articles.id', '=', 'article_contents.article_id')
    //     ->where('category_id', $idCat)
    //     ->where(function($query) use ($newDate){
    //         $query->whereNull('dateBeginPub')->orWhere('dateBeginPub', '<=', $newDate);
    //     })
    //     ->where(function($query) use ($newDate){
    //         $query->whereNull('dateEndPub')->orWhere('dateEndPub', '>=', $newDate);
    //     })
    //     ->whereIn('article_contents.language_id', function($query) use ($thisLang){
    //         $query->select('id')->from('languages')->where('locale', $thisLang);
    //     })
    //     ->orderBy('order', 'ASC')
    //     ->orderBy('dateBeginPub', 'DESC')
    //     ->orderBy('article_contents.name', 'ASC')
    //     ->get();
    //     //dd($articles);
    //     return $articles;
    // }

    /**
     * Save/Insert resource from storage.
     *
     * @param  \App\Models\Shop\Product $product
     * @return \Illuminate\Http\Response
     */
    public static function saveUpdateProduct($data, ?Product $product = null){
        if($product !== null){
            $successMessage = 'Продукт успешно обновлен';
        } else {
            $successMessage = 'Продукт успешно создан';
            $product = new Product();
        }
        //dd($articles);
        try {
            // validate
            if(empty($data['name'])){ throw new \Exception('Название продукта не может быть пустым'); }
            // saves
            DB::beginTransaction();
            $data['hide'] = isset($data['hide']) ? $data['hide'] : false;
            $data['showPrevText'] = isset($data['showPrevText']) ? $data['showPrevText'] : false;
            $data['showSuffixPrice'] = isset($data['showSuffixPrice']) ? $data['showSuffixPrice'] : false;
            // pictures
            foreach(($data['pictures']??[]) AS $k => $item){
                if(empty($item['image'])){
                    unset($data['pictures'][$k]);
                } else {
                    $data['pictures'][$k] = $item['image'];
                }
            }
            empty($data['pictures']) ? $data['pictures'] = null : false;
            $product->fill($data);
            $product->save();
            // many to many updates
            $product->categories()->sync(($data['category_id']??[]));
            //throw new \Exception('STOP');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            (\App\Helpers\AlertFlush::class)::put('error', $e->getMessage());
            return false;
        } catch (\Throwable $e){
            DB::rollback();
            (\App\Helpers\AlertFlush::class)::put('error', $e->getMessage());
            return false;
        }
        (\App\Helpers\AlertFlush::class)::put('success', $successMessage);
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop\Product $product
     */
    public static function deleteProduct(Product $product){
        try {
            $name = $product->name;
            // $product->categories()->detach();
            $product->delete();
        } catch (Exception $e) {
            (\App\Helpers\AlertFlush::class)::put('error', $e->getMessage());
            return Redirect::back()->withInput();
        }
        (\App\Helpers\AlertFlush::class)::put('success', 'Продукт "' . $name . '" успешно удалена');
    }
}