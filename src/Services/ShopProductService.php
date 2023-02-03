<?php
namespace Crghome\Shop\Services;

use App\Helpers\CropImages;
use Carbon\Carbon;
use Crghome\Shop\Models\ImageModel;
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

    /**
     * Save/Insert resource from storage.
     *
     * @param  \Crghome\Shop\Models\Shop\Product $product
     * @return \Illuminate\Http\Response
     */
    public static function saveUpdateProduct($data, ?Product $product = null){
        if($product !== null){
            $successMessage = 'Продукт "' . $product->name . '" успешно обновлен';
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
            empty($data['price']) ? $data['price'] = 0 : false;
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
     * @param  \Crghome\Shop\Models\Shop\Product $product
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