<?php

namespace Crghome\Shop\Casts;

use Crghome\Shop\Models\ImageModel;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ImageCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return \Crghome\Shop\Models\ImageModel
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return ImageModel::getImage($value);
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
        // if (! $value instanceof ImageModel) {
        //     // throw new InvalidArgumentException('The given value is not an Address instance.');
        // }
 
        return json_encode(ImageModel::setImage($value));
    }
}
