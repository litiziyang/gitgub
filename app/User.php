<?php

namespace App;

use EasyWeChat\Factory;
use Exception;
use EasyWeChat\MiniProgram\Application;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

/**
 * App\User
 *
 * @property int                                                        $id
 * @property string|null                                                $name
 * @property Carbon|null                                                $email_verified_at
 * @property string|null                                                $remember_token
 * @property Carbon|null                                                $created_at
 * @property Carbon|null                                                $updated_at
 * @property string|null                                                $phone              手机号
 * @property int                                                        $integral           积分
 * @property float                                                      $balance            余额
 * @property string                                                     $member_type        会员类型 0非会员
 * @property string|null                                                $open_id            微信的ID
 * @property int|null                                                   $default_address_id 默认地址ID
 * @property int                                                        $is_New             是否新用户
 * @property-read Collection|Address[]                                  $addresses
 * @property-read int|null                                              $addresses_count
 * @property-read Image                                                 $avatar
 * @property-read Collection|Cart[]                                     $carts
 * @property-read int|null                                              $carts_count
 * @property-read Collection|Comment[]                                  $comments
 * @property-read int|null                                              $comments_count
 * @property-read Collection|Coupon[]                                   $coupons
 * @property-read int|null                                              $coupons_count
 * @property-read Address                                               $defaultAddress
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null                                              $notifications_count
 * @property-read Collection|Order[]                                    $orders
 * @property-read int|null                                              $orders_count
 * @property-read Collection|Record[]                                   $records
 * @property-read int|null                                              $records_count
 * @property-read Collection|Star[]                                     $stars
 * @property-read int|null                                              $stars_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDefaultAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIntegral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMemberType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'member_type',
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

    const IS_MEMBER = true;
    const NO_MEMBER = false;

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
        return $this->hasOne(Address::class, 'id', 'default_address_id');
    }

    /**
     * 获取Token
     * @return string Token
     */
    public function getToken(): string
    {
        $token = (new Builder())
            ->issuedBy('https://www.leisite.com')
            ->permittedFor('https://www.leisite.com')
            ->IssuedAt(time())
            ->expiresAt(time() + config('app.jwt.time'))
            ->withClaim('id', $this->id)
            ->getToken(new Sha256(), new Key(config('app.jwt.secret')));
        return (string)$token;
    }

    /**
     * 获取微信App
     * @return Application App
     */
    public static function getWechatApp()
    {
        $config = [
            'app_id'        => config('app.wechat.appid'),
            'secret'        => config('app.wechat.secret'),
            'response_type' => 'array',
            'log'           => [
                'level' => 'debug',
                'file'  => __DIR__ . '/wechat.log',
            ],
        ];
        $app    = Factory::miniProgram($config);
        return $app;
    }

    /**
     * Token转UserID
     *
     * @param string $token 凭证
     *
     * @return int token
     */
    public static function tokenToUserID(string $token): int
    {
        $parser = (new Parser())->parse($token);
        if (!$parser->verify(new Sha256(), config('app.jwt.secret'))) {
            return -1;
        }
        if ($parser->isExpired()) {
            return -1;
        }
        return $parser->getClaim('id');
    }
}
