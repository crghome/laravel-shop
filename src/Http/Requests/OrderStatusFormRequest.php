<?php

namespace Crghome\Shop\Http\Requests;

use Crghome\Shop\Http\Requests\ExtendedFormRequest;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class OrderStatusFormRequest extends ExtendedFormRequest
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
        $type_status = $this->type_status;
        empty($type_status) ? $type_status = 'NFR' . rand(100,999) . '_' : false;
        $this->merge([
            'type_status' => $type_status,
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
            'type_status' => [new Enum(\Crghome\Shop\Enum\TypeOrderStatus::class),'max:150'],
            'code' => ['required','unique:\Crghome\Shop\Models\Shop\OrderStatus,code,'.$this->id,'string','max:10'],
            'name' => ['required','string','max:150'],
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
            'type_status.required' => 'Необходимо наличие Кода статуса',
            'type_status.unique' => 'Такой Код уже существует, необходимо изменить',
            'type_status.max' => 'Код превышает :max символов',
            'code.required' => 'Необходимо наличие Кода статуса',
            'code.unique' => 'Такой Код уже существует, необходимо изменить',
            'code.max' => 'Код превышает :max символов',
            'name.required' => 'Необходимо наличие Названия статуса',
            'name.unique' => 'Такое Название уже существует, необходимо изменить',
            'name.max' => 'Название превышает :max символов',
        ];
    }
}
