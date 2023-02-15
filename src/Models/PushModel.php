<?php
namespace Crghome\Shop\Models;

class PushModel{
    /**
     * @param Array|Object $data ['google', 'ios']
     * @return Object
     */
    private static function makePush(Array|Object $data)
    {
        $google = is_object($data) ? ($data->google??[]) : ($data['google']??[]);
        $ios = is_object($data) ? ($data->ios??[]) : ($data['ios']??[]);
        return (object)[
            'google' => !empty($google) ? $google : [],
            'ios' => !empty($ios) ? $ios : [],
        ];
    }

    /**
     * @param Array|Object|String|Null $data
     * @return Object
     */
    public static function getPush(Array|Object|String|Null $data)
    {
        empty($data) ? $data = [] : false;
        $data = is_string($data) ? json_decode($data) : (object)$data;
        return !empty($data) ? self::makePush($data) : [];
    }

    /**
     * @param Array|Object $data
     * @return Object
     */
    public static function setPush(Array|Object $data)
    {
        return !empty($data) ? self::makePush($data) : [];
    }

}