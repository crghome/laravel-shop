<?php
namespace Crghome\Shop\Models;

class MetaModel{
    /**
     * @param Array|Object $data
     * @return Object
     */
    private static function makeMeta(Array|Object $data)
    {
        $description = is_object($data) ? ($data->description??$data->descr??$data->desc??'') : ($data['description']??$data['descr']??$data['desc']??'');
        $keywords = is_object($data) ? ($data->keywords??$data->kwrds??'') : ($data['keywords']??$data['kwrds']??'');
        return (object)[
            'description' => $description,
            'keywords' => $keywords,
        ];
    }

    /**
     * @param Array|Object|String|Null $data
     * @return Object
     */
    public static function getMeta(Array|Object|String|Null $data)
    {
        empty($data) ? $data = [] : false;
        $data = is_string($data) ? json_decode($data) : (object)$data;
        return !empty($data) ? self::makeMeta($data) : [];
    }

    /**
     * @param Array|Object $data
     * @return Object
     */
    public static function setMeta(Array|Object $data)
    {
        return !empty($data) ? self::makeMeta($data) : [];
    }
}