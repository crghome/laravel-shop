<?php

namespace Crghome\Shop\Http\Requests;

use App\Http\Requests\Admin\ExtendedFormRequest;
use Crghome\DescPanel\Services\DpClientService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Str;

class CategoryFormRequest extends ExtendedFormRequest
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
        if(empty($alias)){
            $alias = Str::slug($this->name);
        } else {
            $alias = Str::slug($alias);
        }
        $this->merge([
            'alias' => $alias,
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
            'alias' => ['unique:\Crghome\Shop\Models\Shop\Category,alias,'.$this->id,'string','max:255'],
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
        ];
    }
}
