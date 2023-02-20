<?php

namespace Crghome\Shop\Models\Shop;

use Crghome\Shop\Casts\ImageCast;
use Crghome\Shop\Casts\MetaCast;
use Crghome\Shop\Traits\Models\UserStamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory, UserStamps;
    protected $table = 'crgshop_settings';

    protected $fillable = [
        // shop
        'prevText',
        'fullText',
        'images',
        'pictures',
        'meta',
        // config
        // 'noAuthOfBuy',
        // config prod
        'suffixPrice',
        'countNullProductOfBuy',
        'showPrevText',
        'showSuffixPrice',
        // config status
        'defStatus',
        // stat
        // 'created_user_id',
        'updated_user_id',
    ];

    protected $casts = [
        'meta' => MetaCast::class,
        'images' => ImageCast::class,
        'pictures' => 'object',
        'noAuthOfBuy' => 'boolean',
        'countNullProductOfBuy' => 'boolean',
        'showPrevText' => 'boolean',
        'showSuffixPrice' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct();
        // $this->parent;
        $this->table = config('crghome-shop.db.tables.settings');
    }

    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class, config('crghome-shop.db.tables.category_products'))->withTimestamps();
    // }
}
