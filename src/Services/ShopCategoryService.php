<?php
namespace Crghome\Shop\Services;

use App\Helpers\CropImages;
use Carbon\Carbon;
use Exception;
use Crghome\Shop\Models\ImageModel;
use Crghome\Shop\Models\Shop\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class ShopCategoryService{

    /**
     * @return Int
     */
    public static function getNewCategories(){
        return Category::where('created_at', '>=', Carbon::now()->subDay(7))->count();
    }

    /**
     * @return Int
     */
    public static function getUpdateCategories(){
        return Category::where('updated_at', '>=', Carbon::now()->subDay(7))->count();
    }

    public static function getCategoryOgImage($category){
        $ogImg = '';
        $images = ImageModel::getImage($category->images??'');
        $ogImgFull = !empty($images->prev) ? $images->prev : $images->full;
        if(!empty($ogImgFull) && file_exists($_SERVER['DOCUMENT_ROOT'] . $ogImgFull)){
            $cropImages = new CropImages();
            $ogImg = !empty($ogImgFull) && file_exists($_SERVER['DOCUMENT_ROOT'] . $ogImgFull) ? $cropImages->cropImages($ogImgFull, '/cache/og-image', 300, 70) : config('app.ogimage');
        }

        return $ogImg;
    }

    private static function getPathArr($catAliasReq)
    {
        $result = array();
        if(!empty($catAliasReq)){
            $result = is_string($catAliasReq) ? explode('/', $catAliasReq) : $catAliasReq;
        }
        //echo '<pre>'; var_dump($result); echo '</pre>';
        return $result;
    }
    
    public static function makePath($idParentCat = null)
    {
        $result = '';
        if(!empty($idParentCat)){
            $category = Category::find($idParentCat);
            !empty($category->category_id) ? $result = self::makePath($category->category_id) : false;
            $result .= !empty($result) ? '/' . $category->alias : $category->alias;
        }
        //echo '<pre>'; var_dump($result); echo '</pre>';
        return $result;
    }
    
    /**
     * get Array Eloquent
     * @param \Illuminate\Database\Eloquent\Collection $categories
     * @param Int $level
     * @return Array
     */
    public static function eloquentCategoryToArrayList(Collection $categories, Int $level = 0){
        $response = [];
        foreach (($categories??[]) as $k => $item) {
            if(!in_array($item->id, Arr::pluck($response, 'id'))){
                $item->level = $level;
                $item->last = ($k + 1 == count($categories));
                $response[] = $item;
                !empty($item->categoriesAllChildren) 
                    ? $response = array_merge($response, self::eloquentCategoryToArrayList($item->categoriesAllChildren, ($level + 1))) 
                    : false;
            }
        }
        return $response;
    }

    /**
     * @param Int $idCat
     * @param Array|Int $idsSelectInChild
     * @return Object
     */
    public static function isSetChildCategory(Int $idCat, Array|int $idsSelectInChild){
        is_int($idsSelectInChild) ? $idsSelectInChild = [$idsSelectInChild] : false;
        $res = (object)['status' => false, 'name' => ''];
        $categories = Category::select('id', 'name', 'category_id')->where('category_id', $idCat)->get();
        foreach(($categories??[]) AS $it){
            if(false === $res->status){
                if(in_array($it->id, $idsSelectInChild)){
                    $res->status = true;
                    $res->name = $it->name;
                    break;
                } else {
                    $res = self::isSetChildCategory($it->id, $idsSelectInChild);
                }
            }
        }
        return $res;
    }

    /**
     * @param Int $idCat
     * @param Bool $isArrList
     * @param String $prependText
     * @return Category
     */
    public static function getCategoriesWithoutRecycle(Int $idCat, Bool $isArrList = false, String $prependText = ''){
        $categories = Category::select('id', 'category_id', 'name')->where('id', '!=', $idCat)->where(function($q)use($idCat){ $q->where('category_id', '!=', $idCat)->orWhereNull('category_id'); })->orderBy('name')->get();
        foreach(($categories??[]) AS $k => $it){
            $isSetParent = self::isSetChildCategory($idCat, $it->id);
            if($isSetParent->status){ unset($categories[$k]); }
        }
        if($isArrList && !empty($prependText)) $categories = $categories->pluck('name', 'id')->prepend($prependText, null)->toArray();
        if($isArrList && empty($prependText)) $categories = $categories->pluck('name', 'id')->toArray();
        return $categories;
    }

    /**
     * Save/Insert resource from storage.
     *
     * @param  \Crghome\Shop\Models\Shop\Category  $category
     * @return \Illuminate\Http\Response
     */
    public static function saveUpdateCategory($data, ?Category $category = null){
        if($category !== null){
            $successMessage = 'Категория "' . $category->name . '" успешно обновлена';
        } else {
            $successMessage = 'Категория успешно создана';
            $category = new Category();
        }
        //dd($articles);
        try {
            // validate
            if(empty($data['name'])){ throw new \Exception('Название категории не может быть пустым'); }
            if(!empty($category->id??0) && !empty($data['category_id'])){
                $isSetIn = self::isSetChildCategory($category->id, $data['category_id']);
                if($isSetIn?->status??false){ throw new \Exception('Категория "' . ($isSetIn?->name??'-') . '" в родительских категориях является дочерней'); }
            }
            // saves
            DB::beginTransaction();
            $data['hide'] = isset($data['hide']) ? $data['hide'] : false;
            $data['showPrevText'] = isset($data['showPrevText']) ? $data['showPrevText'] : false;
            //observer $data['path'] = !empty($data['category_id']) ? self::makePath($data['category_id']) . '/' . $data['alias'] : $data['alias'];
            $category->fill($data);
            $category->save();
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
     * @param  \App\Models\Shop\Category $category
     */
    public static function deleteCategory(Category $category){
        try {
            $name = $category->name;
            $category->delete();
        } catch (Exception $e) {
            (\App\Helpers\AlertFlush::class)::put('error', $e->getMessage());
            return Redirect::back()->withInput();
        }
        (\App\Helpers\AlertFlush::class)::put('success', 'Категория "' . $name . '" успешно удалена');
    }
}