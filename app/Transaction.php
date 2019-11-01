<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Transaction
 * @property int         $id
 * @property int         $user_id 用户ID
 * @property string      $number  交易编号
 * @property float       $price   交易金额
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User   $user
 * @property-read Order  $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction query()
 * @mixin Eloquent
 */
class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'price',
        'number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * 生成交易号
     * @return string 交易号字符串
     */
    public static function createTransactionNo(): string
    {
        $order_id_main = date('YmdHis') . rand(10000000, 99999999);
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for ($i = 0; $i < $order_id_len; $i++) {
            $order_id_sum += (int)(substr($order_id_main, $i, 1)) + 1;
        }
        $osn = 'JY' . $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
        return $osn;
    }
}
