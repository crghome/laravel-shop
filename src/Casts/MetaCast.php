<?php

namespace Crghome\Shop\Casts;

use Crghome\Shop\Models\MetaModel;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class MetaCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return \App\Models\MetaModel
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return MetaModel::getMeta($value);
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
        // if (! $value instanceof MetaModel) {
        //     // throw new InvalidArgumentException('The given value is not an Address instance.');
        // }
 
        return json_encode(MetaModel::setMeta($value));
    }
}
