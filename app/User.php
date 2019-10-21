<?php

namespace App;

use EasyWeChat\Factory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function stars()
    {
        return $this->hasMany(Star::class, 'user_id', 'id');
    }

    public function avatar()
    {
        return $this->morphOne(Image::class, 'image');
    }

    public function records()
    {
        return $this->hasMany(Record::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'comment');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'user_id', 'id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id', 'id');
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class, 'default_address_id', 'id');
    }

    /**
     * 获取Token
     * 默认过期时间1小时
     */
    public function getToken()
    {
        $token = (new Builder())
            ->setIssuer('https://www.leisite.com')
            ->setAudience('https://www.leisite.com')
            ->setIssuedAt(time())
            ->setExpiration(time() + env('JWTTIME', 3600))
            ->set('id', $this->id)
            ->sign(new Sha256(), config('app.jwt.secret'))
            ->getToken();
        return (string) $token;
    }

    public static function getWechatApp()
    {
        $config = [
            'app_id'        => env('WECHAT_APPID', ''),
            'secret'        => env('WECHAT_SECRET', ''),
            'response_type' => 'array',
            'log'           => [
                'level' => 'debug',
                'file'  => __DIR__ . '/wechat.log',
            ],
        ];
        $app = Factory::miniProgram($config);
        return $app;
    }
}
