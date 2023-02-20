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
        $name = is_object($data) ? ($data->name??'') : ($data['name']??'');
        $image = is_object($data) ? ImageModel::setImage($data->image??[]) : ImageModel::setImage($data['image']??[]);
        $attrib = is_object($data) ? ($data->attrib??[]) : ($data['attrib']??[]);
        $count = is_object($data) ? ($data->count??'') : ($data['count']??'');
        $amount = is_object($data) ? ($data->amount??'') : ($data['amount']??'');
        return (object)[
            'id' => !empty($id) ? $id : '',
            'name' => !empty($name) ? $name : '',
            'image' => !empty($image) ? $image : [],
            'attrib' => !empty($attrib) ? $attrib : [],
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