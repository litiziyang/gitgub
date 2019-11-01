<?php


namespace App\Services\Implement;


use App\Http\Resources\BaseResource;
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
     * @param integer $number 订单号
     * @param float   $price  付的价格
     *
     * @return Transaction 交易内容
     * @throws Exception
     */
    public function create(string $token, $number, $price): Transaction
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
        $order = $this->orderRepository->findOrFail([
            'id'     => $token_id,
            'number' => $token_number,
            'price'  => $token_price
        ]);
        if ($order->price != $price || $order->number != $number) {
            throw new Exception('交易异常');
        }
        
    }
}
