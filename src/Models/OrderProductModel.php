<?php
namespace Crghome\Shop\Models;

class OrderProductModel{
    /**
     * @param Array|Object $data ['google', 'ios']
     * @return Object
     */
    private static function makeProduct(Array|Object $data)
    {
        $id = is_object($data) ? ($data->id??'') : ($data['id']??'');
        $count = is_object($data) ? ($data->count??'') : ($data['count']??'');
        $amount = is_object($data) ? ($data->amount??'') : ($data['amount']??'');
        return (object)[
            'id' => !empty($id) ? $id : '',
            'count' => !empty($count) ? $count : '',
            'amount' => !empty($amount) ? $amount : '',
        ];
    }

    /**
     * @param Array|Object|String|Null $data
     * @return Object
     */
    public static function getProduct(Array|Object|String|Null $data)
    {
        empty($data) ? $data = [] : false;
        $data = is_string($data) ? json_decode($data, true) : (object)$data;
        return !empty($data) ? self::makeProduct($data) : [];
    }

    /**
     * @param Array|Object $data
     * @return Object
     */
    public static function setProduct(Array|Object $data)
    {
        return !empty($data) ? self::makeProduct($data) : [];
    }

}