<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

/**
 * App\Order
 *
 * @property int                         $id
 * @property string                      $number         订单标号
 * @property int|null                    $transaction_id 交易编号
 * @property int                         $user_id        用户ID
 * @property string                      $state          订单状态 0 待付款 1 待发货 2 待收货 3 待评价 4 已失败 5 已完成
 * @property float                       $reward         奖励金额
 * @property float                       $price          价格
 * @property string                      $address        地址
 * @property string                      $name           名字
 * @property string                      $phone          电话
 * @property string                      $remarks        备注
 * @property string                      $description    详细地址
 * @property string                      $longitude      经度
 * @property string                      $latitude       纬度
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $updated_at
 * @property-read Transaction            $transaction
 * @property-read User                   $user
 * @property-read Coupon                 $coupon
 * @property-read Collection|OrderGood[] $orderGood
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserId($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'coupon_id',
        'number',
        'price',
        'name',
        'address',
        'phone',
        'description',
        'remarks',
        'longitude',
        'latitude',
    ];

    /**
     * 待付款
     */
    const PENDING_PAYMENT = '0';
    /**
     * 待发货
     */
    const BEING_PROCESSED = '1';
    /**
     * 待收货
     */
    const SHIPPED = '2';
    /**
     * 待评价
     */
    const EVALUATE = '3';
    /**
     * 已失效
     */
    const INVALID = '4';
    /**
     * 已完成
     */
    const COMPLETED = '5';
    /**
     * 售后
     */
    const AFTER_SALE = '6';

    /**
     * 获取状态名称
     *
     * @param integer $state 状态码
     *
     * @return string 状态名称
     */
    public static function getStateName($state): string
    {
        $name = '';
        switch ($state) {
            case self::PENDING_PAYMENT :
                $name = '待付款';
                break;
            case self::BEING_PROCESSED :
                $name = '待发货';
                break;
            case self::SHIPPED :
                $name = '待收货';
                break;
            case self::EVALUATE :
                $name = '待评价';
                break;
            case self::INVALID :
                $name = '已失效';
                break;
            case self::COMPLETED :
                $name = '已完成';
                break;
            case self::AFTER_SALE:
                $name = '售后';
                break;
        }
        return $name;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class, 'coupon_id', 'id');
    }

    public function orderGood()
    {
        return $this->hasMany(OrderGood::class, 'order_id', 'id');
    }

    /**
     * @return string 生成订单号
     */
    public static function createOrderNo(): string
    {
        $order_id_main = date('YmdHis') . rand(10000000, 99999999);
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for ($i = 0; $i < $order_id_len; $i++) {
            $order_id_sum += (int)(substr($order_id_main, $i, 1));
        }
        $osn = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
        return $osn;
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
            ->expiresAt(time() + config('app.jwt.pay.time'))
            ->withClaim('id', $this->id)
            ->withClaim('number', $this->number)
            ->withClaim('price', $this->price)
            ->getToken(new Sha256(), new Key(config('app.jwt.pay.secret')));
        return (string)$token;
    }
}
