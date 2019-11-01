<?php


namespace App\Services;


use App\Transaction;

interface TransactionService
{
    /**
     * 支付成功生成交易
     *
     * @param string  $token
     * @param integer $number 订单号
     * @param float   $price  付的价格
     *
     * @return Transaction 交易内容
     */
    public function create(string $token, $number, $price): Transaction;
}
