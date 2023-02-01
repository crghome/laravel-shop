<?php

namespace Crghome\Shop\Models\Shop;

use App\Casts\ImageCast;
use App\Casts\MetaCast;
use App\Traits\Models\UserStamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, UserStamps;
    protected $table = 'crgshop_products';

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
        'suffixPrice',
        'meta',
        'dateBeginPub',
        'dateEndPub',
        'hide',
        'order',
        'showPrevText',
        'showSuffixPrice',
    ];

    protected $casts = [
        'meta' => MetaCast::class,
        'images' => ImageCast::class,
        'pictures' => 'object',
        'price' => 'float',
        'price_old' => 'float',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('crghome-shop.db.tables.products');
        $this->parent;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'crgshop_category_products')->withTimestamps();
    }
}
