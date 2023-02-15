<?php
namespace Crghome\Shop\Services;

use App\Helpers\CropImages;
use Carbon\Carbon;
use Crghome\Shop\Models\ImageModel;
use Crghome\Shop\Models\Shop\Client;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ShopClientService{

    /**
     * @return Int
     */
    public static function getNewClients(){
        return Client::where('created_at', '>=', Carbon::now()->subDay(7))->count();
    }

    /**
     * @return Int
     */
    public static function getUpdateClients(){
        return Client::where('updated_at', '>=', Carbon::now()->subDay(7))->count();
    }

    public static function getClientOgImage($client){
        $ogImg = '';
        $images = ImageModel::getImage($client->images??'');
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
     * @param  \Crghome\Shop\Models\Shop\Client $client
     * @return \Illuminate\Http\Response
     */
    public static function saveUpdateClient($data, ?Client $client = null){
        if($client !== null){
            $successMessage = 'Клиент "' . $client->name . '" успешно обновлен';
        } else {
            $successMessage = 'Клиент успешно создан';
            $client = new Client();
        }
        //dd($articles);
        try {
            // validate
            if(empty($data['login'])){ throw new \Exception('Login клиента не может быть пустым'); }
            if(empty($data['name'])){ throw new \Exception('Имя клиента не может быть пустым'); }
            if(empty($data['phone'])){ throw new \Exception('Телефон клиента не может быть пустым'); }
            if(empty($client->password) && empty($data['password']) && empty($data['password_confirmation'])){ throw new \Exception('Пароль не может быть пустым'); }
            if(!empty($data['password']) && ($data['password'] != $data['password_confirmation'])){ throw new \Exception('Не совпадают введенные пароли'); }
            // saves
            DB::beginTransaction();
            $data['phone'] = preg_replace('/[\+\-\ \(\)]/', '', $data['phone']);
            $data['email'] = trim($data['email']);
            if(!empty($data['password']) && ($data['password'] == $data['password_confirmation'])){
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            $data['accessed'] = isset($data['accessed']) ? $data['accessed'] : false;
            $data['moderated'] = isset($data['moderated']) ? $data['moderated'] : false;
            $data['subs_news'] = isset($data['subs_news']) ? $data['subs_news'] : false;
            $data['subs_actions'] = isset($data['subs_actions']) ? $data['subs_actions'] : false;
            $client->fill($data);
            $client->save();
            // many to many updates
            // $client->categories()->sync(($data['category_id']??[]));
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
     * @param  \Crghome\Shop\Models\Shop\Client $client
     */
    public static function deleteClient(Client $client){
        try {
            $name = $client->name;
            // $client->categories()->detach();
            $client->delete();
        } catch (Exception $e) {
            (\App\Helpers\AlertFlush::class)::put('error', $e->getMessage());
            return Redirect::back()->withInput();
        }
        (\App\Helpers\AlertFlush::class)::put('success', 'Клиент "' . $name . '" успешно удален');
    }
}