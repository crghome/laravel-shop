<?php
namespace Crghome\Shop\Enum;

enum TypeOrderStatus: string
{
    case order = 'Заказ';
    case delivery = 'Доставка';
    case feedback = 'Спор';
    case done = 'Выполнен';
}