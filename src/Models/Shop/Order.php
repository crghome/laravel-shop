<?php

namespace Crghome\Shop\Models\Shop;

use Crghome\Shop\Casts\OrderProductCast;
use Illuminate\Database\Eloquent\Casts\AsEnumArrayObject;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'client_id',
        'status_id',
        'products',
        'client_name',
        'client_phone',
        'client_email',
        'client_company',
        'amount',
    ];

    protected $casts = [
        // 'products' => 'array',
        'products' => AsArrayObject::class.':'.OrderProductCast::class,
        'amount' => 'float',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct();
        // $this->parent;
        $this->table = config('crghome-shop.db.tables.orders');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }
}
