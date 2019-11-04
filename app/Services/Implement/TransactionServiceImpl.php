<?php


namespace App\Services\Implement;


use App\Order;
use App\Services\TransactionService;
use App\Transaction;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Exception;

class TransactionServiceImpl implements TransactionService
{

    protected $transactionRepository;
    protected $orderRepository;

    public function __construct(Transaction $transaction, Order $order)
    {
        $this->transactionRepository = $transaction->query();
        $this->orderRepository = $order->query();
    }

    /**
     * 支付成功生成交易
     *
     * @param string  $token
     * @param integer $number  订单号
     * @param float   $price   付的价格
     * @param integer $user_id 用户ID
     *
     * @return Transaction 交易内容
     * @throws Exception
     */
    public function create(string $token, $number, $price, $user_id): Transaction
    {
        $parser = (new Parser())->parse($token);
        if (!$parser->verify(new Sha256(), config('app.jwt.pay.secret'))) {
            throw new Exception('交易异常');
        }
        if ($parser->isExpired()) {
            throw new Exception('交易超时');
        }
        $token_id = $parser->getClaim('id');
        $token_number = $parser->getClaim('number');
        $token_price = $parser->getClaim('price');
        $order = $this->orderRepository
            ->where('id', $token_id)
            ->where('price', $token_price)
            ->where('number', $token_number)
            ->first();
        if ($order->price != $price || $order->number != $number) {
            throw new Exception('交易异常');
        }
        \DB::beginTransaction();
        $transaction = $this->transactionRepository->create([
            'user_id'  => $user_id,
            'price'    => $price,
            'number'   => Transaction::createTransactionNo(),
            'order_id' => $order->id
        ]);
        // 订单状态改为待发货
        $order->state = Order::BEING_PROCESSED;
        $order->transaction_id = $transaction->id;
        $order->save();
        // 商品销量增加
        $orderGoods = $order->orderGood;
        foreach ($orderGoods as $good) {
            $commodity = $good->commodity;
            if ($commodity) {
                $commodity->count_sales += $good->count;
                $commodity->save();
            }
        }
        \DB::commit();
        return $transaction;
    }
}
