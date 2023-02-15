<?php
namespace Crghome\Shop\Services;

use App\Helpers\CropImages;
use Carbon\Carbon;
use Crghome\Shop\Casts\OrderProductCast;
use Crghome\Shop\Models\ImageModel;
use Crghome\Shop\Models\OrderProductModel;
use Crghome\Shop\Models\Shop\Order;
use Crghome\Shop\Models\Shop\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ShopOrderService{
    /**
     * @param String $prefix
     * @param String $code
     * @return String
     */
    public static function getNumberOrder(String $prefix = '', String $code = ''){
        $numberRaw = !empty($prefix) ? $prefix . '-' : 'PN-';
        $numberRaw .= date('Ymd-His');
        !empty($code) ? $numberRaw .= '-' . $code : false;
        $number = $numberRaw;
        $i = 1;
        while(Order::where('number', $number)->count()){
            $number = $numberRaw . '-' . $i;
            $i++;
        }
        return $number;
    }

    /**
     * @return Int
     */
    public static function getNewOrders(){
        return Order::where('created_at', '>=', Carbon::now()->subDay(7))->count();
    }

    /**
     * @return Int
     */
    public static function getUpdateOrders(){
        return Order::where('updated_at', '>=', Carbon::now()->subDay(7))->count();
    }

    /**
     * Save/Insert resource from storage.
     *
     * @param  \Crghome\Shop\Models\Shop\Order $order
     * @return \Illuminate\Http\Response
     */
    public static function saveUpdateOrder($data, ?Order $order = null){
        if($order !== null){
            $successMessage = 'Заказ "' . $order->number . '" успешно обновлен';
        } else {
            $successMessage = 'Заказ успешно создан';
            $order = new Order();
        }
        //dd($articles);
        try {
            // validate
            if(empty($data['products'])){ throw new \Exception('Не найдены товары'); }
            $idsProd = array_column($data['products'], 'id');
            $countProd = array_column($data['products'], 'count');
            $amountProd = array_column($data['products'], 'amount');
            if(empty($idsProd)){ throw new \Exception('Не найдены ключи товаров'); }
            if(count($idsProd) != count($countProd) || count($idsProd) != count($amountProd)){ throw new \Exception('Не все данные товаров поступили в заказе'); }
            if(Product::whereIn('id', $idsProd)->count() != count($data['products'])){ throw new \Exception('Некоторые продукты не доступны для покупки'); }
            // saves
            DB::beginTransaction();
            $data['client_phone'] = preg_replace('/[\+\-\ \(\)]/', '', $data['client_phone']);
            $data['client_email'] = trim($data['client_email']);
            // $data['subs_actions'] = isset($data['subs_actions']) ? $data['subs_actions'] : false;
            $products = [];
            $amount = 0;
            foreach($data['products'] AS $prod){
                $products[] = OrderProductModel::setProduct($prod);
                $amount += $prod['amount'];
            }
            $data['amount'] = $amount;
            $data['products'] = $products;
            if(empty($data['products'])){ throw new \Exception('Не смогли разобрать товары'); }
            empty($data['number']) ? self::getNumberOrder(($data['number_prefix']??''), substr($data['client_phone'], (strlen($data['client_phone']) - 4), strlen($data['client_phone']))) : false;
            // throw new \Exception('PRE SAVE');
            // dd($data);
            $order->fill($data);
            $order->save();
            // many to many updates
            // $order->categories()->sync(($data['category_id']??[]));
            // throw new \Exception('STOP');
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
     * @param  \Crghome\Shop\Models\Shop\Order $order
     */
    public static function deleteOrder(Order $order){
        try {
            $number = $order->number;
            // $order->categories()->detach();
            $order->delete();
        } catch (Exception $e) {
            (\App\Helpers\AlertFlush::class)::put('error', $e->getMessage());
            return Redirect::back()->withInput();
        }
        (\App\Helpers\AlertFlush::class)::put('success', 'Заказ "' . $number . '" успешно удален');
    }
}