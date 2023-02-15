<?php

namespace Crghome\Shop\Http\Requests;

use App\Http\Requests\Admin\ExtendedFormRequest;
use App\Services\FileStorageService;

class ClientFormRequest extends ExtendedFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // $request = Request();
        // $file = $this->photo;
        // $photo_old = $this->photo_old;
        // if(!empty($file)){
        //     $storage = !empty($this->id??'') ? 'u'.$this->id : 'uT'.rand(100,999);
        //     $arrData = FileStorageService::setFiles('users', $storage, $file, true, $photo_old);
        //     $photo_old = $arrData->url;

        //     $data = $this->all();
        //     $data['photo_old'] = $photo_old;
        //     $data['photo'] = '';
        //     $this->merge(['photo_old' => $photo_old]);

        //     session()->flash('photo_old', $photo_old);
        // }
        
        // return parent::getValidatorInstance();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $passwordRule = 'required';
        if(in_array((request()->method()??'POST'), ['PUT','PATCH'])){
            $passwordRule = 'nullable';
        }
        
        return [
            'login' => ['required', 'string', 'unique:Crghome\Shop\Models\Shop\Client,login,'.$this->id, 'max:150'],
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'string', 'email', 'max:50'],
            'password' => [$passwordRule, 'string', 'confirmed'],
            'company' => ['nullable', 'string', 'max:255'],
            // 'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webm,webp|max:8048',
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'login.required' => 'Поле Логин обязательно для заполнения',
            'login.unique' => 'Логин ":input" уже занят, придумайте другой',
            'login.max' => 'Логин превысил :max символов',
            'name.required' => 'Поле Имя обязательно для заполнения',
            'name.max' => 'Имя превысило :max символов',
            'phone.required' => 'Поле Телефон обязательно для заполнения',
            'phone.max' => 'Телефон превысил :max символов',
            'email.email' => '":input" не является корректным адресом электронной почты',
            'email.max' => 'Email превысил :max символов',
            'password.required' => 'Необходимо ввести пароль',
            'password.confirmed' => 'Введеные пароли не совпадают',
            'photo.max' => 'Слишком длинное имя',
        ];
    }
}
