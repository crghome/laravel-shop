<?php

namespace Crghome\Shop\Casts;

use Crghome\Shop\Models\PushModel;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PushCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return \Crghome\Shop\Models\PushModel
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return PushModel::getPush($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return json_encode(PushModel::setPush($value));
    }
}
