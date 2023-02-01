<?php
namespace Crghome\Shop\Models;

class ImageModel{
    /**
     * @param Array|Object $data ['prev', 'full']
     * @param String $path
     * @return Object $images
     */
    private static function makeImage(Array|Object $data, String $path = '')
    {
        $prev = is_object($data) ? ($data->previous??$data->prev??'') : ($data['previous']??$data['prev']??'');
        $full = is_object($data) ? ($data->full??'') : ($data['full']??'');
        return (object)[
            'prev' => !empty($prev) ? $path . $prev : '',
            'full' => !empty($full) ? $path . $full : '',
        ];
    }

    /**
     * @param Array|Object|String|Null $data
     * @return Object
     */
    public static function getImage(Array|Object|String|Null $data)
    {
        empty($data) ? $data = [] : false;
        $data = is_string($data) ? json_decode($data) : (object)$data;
        return !empty($data) ? self::makeImage($data) : [];
    }

    /**
     * @param Array|Object $data
     * @return Object
     */
    public static function setImage(Array|Object $data)
    {
        return !empty($data) ? self::makeImage($data) : [];
    }

}