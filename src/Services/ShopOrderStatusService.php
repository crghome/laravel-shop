<?php
namespace Crghome\Shop\Services;

use App\Helpers\CropImages;
use Carbon\Carbon;
use Crghome\Shop\Enum\TypeOrderStatus;
use Crghome\Shop\Models\ImageModel;
use Crghome\Shop\Models\Shop\OrderStatus;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ShopOrderStatusService{

    /**
     * @return Int
     */
    public static function getNewOrderStatuses(){
        return OrderStatus::where('created_at', '>=', Carbon::now()->subDay(7))->count();
    }

    /**
     * @return Int
     */
    public static function getUpdateOrderStatuses(){
        return OrderStatus::where('updated_at', '>=', Carbon::now()->subDay(7))->count();
    }

    /**
     * @return Array
     */
    public static function getTypesOrderStatuses(){
        $typesEnum = TypeOrderStatus::cases();
        $typesEnum = !empty($typesEnum) ? Arr::collapse(array_map(function($val){ return [$val->value => $val->name]; }, $typesEnum)) : [];
        return $typesEnum;
    }

    /**
     * Save/Insert resource from storage.
     *
     * @param  \Crghome\Shop\Models\Shop\OrderStatus $orderStatus
     * @return \Illuminate\Http\Response
     */
    public static function saveUpdateOrderStatus($data, ?OrderStatus $orderStatus = null){
        if($orderStatus !== null){
            $successMessage = 'Статус "' . $orderStatus->name . '" успешно обновлен';
        } else {
            $successMessage = 'Статус успешно создан';
            $orderStatus = new OrderStatus();
        }
        //dd($articles);
        try {
            // validate
            if(empty($data['type_status'])){ throw new \Exception('Тип статуса обязательно'); }
            if(empty($data['name'])){ throw new \Exception('Название статуса не может быть пустым'); }
            if(empty($data['code'])){ throw new \Exception('Код статуса не может быть пустым'); }
            // saves
            DB::beginTransaction();
            // $data['hide'] = isset($data['hide']) ? $data['hide'] : false;
            $orderStatus->fill($data);
            $orderStatus->save();
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
     * @param  \Crghome\Shop\Models\Shop\OrderStatus $orderStatus
     */
    public static function deleteOrderStatus(OrderStatus $orderStatus){
        try {
            $name = $orderStatus->name;
            $orderStatus->delete();
        } catch (Exception $e) {
            (\App\Helpers\AlertFlush::class)::put('error', $e->getMessage());
            return Redirect::back()->withInput();
        }
        (\App\Helpers\AlertFlush::class)::put('success', 'Статус "' . $name . '" успешно удалена');
    }
}