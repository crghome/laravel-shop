<?php

namespace Crghome\Shop\Http\Requests;

use Crghome\Shop\Http\Requests\ExtendedFormRequest;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class SettingsFormRequest extends ExtendedFormRequest
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
        // $alias = $this->alias;
        // $alias = empty($alias) ? Str::slug($this->name) : Str::slug($alias);
        // $this->merge([
        //     'alias' => $alias,
        // ]);

        // return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'name' => ['required','string','max:255'],
            // 'alias' => ['unique:\Crghome\Shop\Models\Shop\Product,alias,'.$this->id,'string','max:255'],
            'prevText' => ['nullable','string'],
            'fullText' => ['nullable','string'],
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
            // 'name.required' => 'Необходимо наличие названия',
            // 'name.max' => 'Название не может превышать :max символов',
            // 'alias.unique' => 'Такой Алиас существует, необходимо изменить',
        ];
    }
}
