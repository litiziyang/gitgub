<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Order
 *
 * @property int              $id
 * @property int              $number 订单编号编号
 * @property int|null         $transaction_id 交易编号
 * @property int              $user_id 用户ID
 * @property string           $state 订单状态
 * @property Carbon|null      $created_at
 * @property Carbon|null      $updated_at
 * @property-read Transaction $transaction
 * @property-read User        $user
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
    protected $fillable = [
        'number',
        'user_id',
        'state',
        'transaction_id',
        'reward',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }
}
