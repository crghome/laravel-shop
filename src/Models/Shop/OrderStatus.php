<?php

namespace Crghome\Shop\Models\Shop;

use Crghome\Shop\Casts\ImageCast;
use Crghome\Shop\Casts\OrderProductCast;
use Crghome\Shop\Enum\TypeOrderStatus;
use Illuminate\Database\Eloquent\Casts\AsEnumArrayObject;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_status',
        'code',
        'name',
        'images',
        'css_class',
        'icon_class',
        'icon_base',
        'order',
        'remark',
    ];

    protected $casts = [
        'type_status' => TypeOrderStatus::class,
        'images' => ImageCast::class,
        'amount' => 'float',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct();
        // $this->parent;
        $this->table = config('crghome-shop.db.tables.statuses');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
