<?php

namespace Crghome\Shop\Http\Requests;

use Crghome\Shop\Http\Requests\ExtendedFormRequest;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class ProductFormRequest extends ExtendedFormRequest
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
        $alias = $this->alias;
        $price = $this->price;
        $price_old = $this->price_old;
        $alias = empty($alias) ? Str::slug($this->name) : Str::slug($alias);
        $price = empty($price) ? 0 : preg_replace('/\,/', '.', $price);
        $price_old = empty($price_old) ? 0 : (float)preg_replace('/\,/', '.', $price_old);
        $this->merge([
            'alias' => $alias,
            'price' => $price,
            'price_old' => $price_old,
        ]);

        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'parent_id' => ['integer'],
            'name' => ['required','string','max:255'],
            'alias' => ['unique:\Crghome\Shop\Models\Shop\Product,alias,'.$this->id,'string','max:255'],
            'price' => ['required','numeric'],
            'price_old' => ['required','numeric'],
            'dateBeginPub' => ['date'],
            //'dateEndPub' => ['string','max:25'],
            //'order'=>['string','max:25'],
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
            'name.required' => 'Необходимо наличие названия',
            'name.max' => 'Название не может превышать :max символов',
            'alias.unique' => 'Такой Алиас существует, необходимо изменить',
            'name.string' => 'Заполните название админу',
            'price.required' => 'Цена должна быть заполнена',
            'price.numeric' => 'Цена должна быть числом',
            'price_old.required' => 'Старая цена должна быть заполнена',
            'price_old.numeric' => 'Старая цена должна быть числом',
        ];
    }
}
