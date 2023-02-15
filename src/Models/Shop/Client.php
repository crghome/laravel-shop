<?php

namespace Crghome\Shop\Models\Shop;

use Crghome\Shop\Casts\ImageCast;
use Crghome\Shop\Casts\PushCast;
use Crghome\Shop\Traits\Models\UserStamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, UserStamps;

    protected $fillable = [
        'login',
        'name',
        'phone',
        'email',
        'company',
        'address',
        // 'phone_verified_code',
        // 'phone_verified_at',
        // 'email_verified_at',
        'password',
        'password_verified',
        'accessed',
        'moderated',
        'last_used_at',
        'images',
        // 'created_user_id',
        'updated_user_id',
        'subs_news',
        'subs_actions',
        'subs_push',
    ];

    protected $casts = [
        'images' => ImageCast::class,
        'phone_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'last_used_at' => 'datetime',
        'subs_push' => PushCast::class,
        'subs_news' => 'boolean',
        'subs_actions' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'phone_verified_code',
        'password',
        'remember_token',
        'sync_1C',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct();
        // $this->parent;
        $this->table = config('crghome-shop.db.tables.clients');
    }

    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class, config('crghome-shop.db.tables.category_products'))->withTimestamps();
    // }
}
