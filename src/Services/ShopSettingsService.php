<?php
namespace Crghome\Shop\Services;

use App\Helpers\CropImages;
use Carbon\Carbon;
use Crghome\Shop\Models\ImageModel;
use Crghome\Shop\Models\Shop\Settings;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ShopSettingsService{

    /**
     * @return Int
     */
    public static function getNewSettings(){
        return Settings::where('created_at', '>=', Carbon::now()->subDay(7))->count();
    }

    /**
     * @return Int
     */
    public static function getUpdateSettings(){
        return Settings::where('updated_at', '>=', Carbon::now()->subDay(7))->count();
    }

    /**
     * @param Eloquent $settings
     * @return String
     */
    public static function getSettingsOgImage($settings){
        $ogImg = '';
        $images = ImageModel::getImage($settings->images??'');
        $ogImgFull = !empty($images->prev) ? $images->prev : $images->full;
        if(!empty($ogImgFull) && file_exists($_SERVER['DOCUMENT_ROOT'] . $ogImgFull)){
            $cropImages = new CropImages();
            $ogImg = !empty($ogImgFull) && file_exists($_SERVER['DOCUMENT_ROOT'] . $ogImgFull) ? $cropImages->cropImages($ogImgFull, '/cache/og-image', 300, 70) : config('app.ogimage');
        }

        return $ogImg;
    }

    /**
     * @param Eloquent $settings
     * @return Eloquent
     */
    public static function getConfiguration(){
        $config = Settings::firstOrCreate();
        return $config;
    }

    /**
     * Save/Insert resource from storage.
     *
     * @param  \Crghome\Shop\Models\Shop\Settings $settings
     * @return \Illuminate\Http\Response
     */
    public static function saveUpdateSettings($data, ?Settings $settings = null){
        if($settings !== null){
            $successMessage = 'Настройки успешно обновлены';
        } else {
            $successMessage = 'Настройки успешно созданы';
            $settings = new Settings();
        }
        //dd($articles);
        try {
            // validate
            // if(empty($data['name'])){ throw new \Exception('Название настроек не может быть пустым'); }
            // saves
            DB::beginTransaction();
            $data['countNullProductOfBuy'] = isset($data['countNullProductOfBuy']) ? $data['countNullProductOfBuy'] : false;
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
            $settings->fill($data);
            $settings->save();
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
     * @param  \Crghome\Shop\Models\Shop\Settings $settings
     */
    public static function deleteSettings(Settings $settings){
        try {
            $name = $settings->name;
            $settings->delete();
        } catch (Exception $e) {
            (\App\Helpers\AlertFlush::class)::put('error', $e->getMessage());
            return Redirect::back()->withInput();
        }
        (\App\Helpers\AlertFlush::class)::put('success', 'Продукт "' . $name . '" успешно удалена');
    }
}