<?php
namespace Crghome\Shop\Services;

use App\Helpers\CropImages;
use Carbon\Carbon;
use Exception;
use Crghome\Shop\Models\ImageModel;
use Crghome\Shop\Models\Shop\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

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
     * Save/Insert resource from storage.
     *
     * @param  \Crghome\Shop\Models\Shop\Category  $category
     * @return \Illuminate\Http\Response
     */
    public static function saveUpdateCategory($data, ?Category $category = null){
        if($category !== null){
            $successMessage = 'Категория успешно обновлена';
        } else {
            $successMessage = 'Категория успешно создана';
            $category = new Category();
        }
        //dd($articles);
        try {
            // validate
            if(empty($data['name'])){ throw new \Exception('Название категории не может быть пустым'); }
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