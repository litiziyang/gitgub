<?php

namespace App\Repositories;

use App\Address;

interface AddressRepository
{
    /**
     * 新增地址
     *
     * @param array $address 地址内容
     *
     * @return Address 创建的实例
     */
    public function create(array $address): Address;
}
