<?php

namespace Crghome\Shop\Models\Shop;

use Crghome\Shop\Casts\ImageCast;
use Crghome\Shop\Casts\MetaCast;
use Crghome\Shop\Traits\Models\UserStamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, UserStamps;
    protected $table = 'crgshop_categories';

    protected $fillable = [
        'category_id',
        'name',
        'title',
        'alias',
        'path',
        'prevText',
        'fullText',
        'images',
        'meta',
        'dateBeginPub',
        'dateEndPub',
        'hide',
        'order',
        'showPrevText',
    ];

    protected $casts = [
        'meta' => MetaCast::class,
        'images' => ImageCast::class,
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('crghome-shop.db.tables.categories');
        $this->parent;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function categoriesAllChildren()
    {
        return $this->hasMany(Category::class)->with('categoriesAllChildren');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'crgshop_category_products')->withTimestamps();
    }
}
