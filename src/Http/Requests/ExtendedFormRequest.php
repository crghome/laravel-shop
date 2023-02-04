<?php

namespace Crghome\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExtendedFormRequest extends FormRequest
{
    protected function getRedirectUrl(){
        $err = $this->getValidatorInstance()->errors()->toArray();
        $errArr = [];
        foreach(($err??[]) AS $v) $errArr[] = implode(' ', $v);
        !empty($errArr) ? (\App\Helpers\AlertFlush::class)::put('error', '<ul><li>' . implode('</li><li>', $errArr) . '</li></ul>') : false;
        parent::getRedirectUrl();
    }
}
