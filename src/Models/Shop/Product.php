<?php

namespace Crghome\Shop\Models\Shop;

use Crghome\Shop\Casts\ImageCast;
use Crghome\Shop\Casts\MetaCast;
use Crghome\Shop\Traits\Models\UserStamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, UserStamps;
    // protected $table = 'crgshop_products';

    protected $fillable = [
        'name',
        'title',
        'alias',
        'prevText',
        'fullText',
        'images',
        'pictures',
        'price',
        'price_old',
        'count',
        'suffixPrice',
        'meta',
        'dateBeginPub',
        'dateEndPub',
        'hide',
        'order',
        'showPrevText',
        'showSuffixPrice',
        // 'created_user_id',
        'updated_user_id',
        // 'views',
    ];

    protected $casts = [
        'meta' => MetaCast::class,
        'images' => ImageCast::class,
        'pictures' => 'object',
        'price' => 'float',
        'price_old' => 'float',
        'count' => 'integer',
        'showPrevText' => 'boolean',
        'showSuffixPrice' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct();
        // $this->parent;
        $this->table = config('crghome-shop.db.tables.products');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, config('crghome-shop.db.tables.category_products'))->withTimestamps();
    }
}
