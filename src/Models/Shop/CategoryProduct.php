<?php

namespace Crghome\Shop\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryProduct extends Model
{
    use HasFactory;
    protected $table = 'crgshop_category_products';

    protected $fillable = [
        'category_id',
        'product_id',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('crghome-shop.db.tables.category_products');
        $this->parent;
    }

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
