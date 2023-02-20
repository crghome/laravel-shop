<?php
namespace Crghome\Shop\Enum;

use Illuminate\Support\Arr;

enum TypeOrderStatus: string
{
    case Заказ = 'order';
    case Доставка = 'delivery';
    case Спор = 'feedback';
    case Выполнен = 'done';

    /**
     * @param String $value
     * @return Array
     */
    public static function fromLike(String $value = '', String $label = ''){
        $cases = self::cases();
        $filtered = [];
        // dump($cases, $value, $label, '->');
        foreach($cases AS $v){
            $posL = !empty($v->name??'') && !empty($label) ? strpos(mb_strtolower($v->name), mb_strtolower($label)) : false;
            $posV = !empty($v->value??'') && !empty($value) ? strpos(mb_strtolower($v->value), mb_strtolower($value)) : false;
            $posL !== false || $posV !== false ? $filtered[] = $v : false;
            // dump($v->name, $posL, '---');
        }
        // dump($filtered);
        return $filtered;
    }

    // public static function getLabel() : string
    // {
    //     return match($this){
    //         self::Заказ => 'Заказ',
    //         self::Доставка => 'Доставка',
    //         self::Спор => 'Спор',
    //         self::Выполнен => 'Выполнен',
    //     };
    // }
}