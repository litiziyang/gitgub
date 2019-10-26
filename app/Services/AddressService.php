<?php

namespace App\Services;

use App\Address;
use App\User;

interface AddressService
{
    /**
     * 新增地址
     *
     * @param array $address 地址内容
     *
     * @return Address
     */
    public function create(array $address): Address;

    /**
     * 获取单个地址
     *
     * @param integer $id 地址ID
     *
     * @return Address
     */
    public function find($id): Address;

    /**
     * 更新地址
     *
     * @param array   $newAddress 新的地址内容
     * @param Address $oldAddress 旧的地址实例
     *
     * @return boolean 是否成功
     */
    public function update(array $newAddress, Address $oldAddress): bool;

    /**
     * 获取默认地址
     *
     * @param User $user 用户
     *
     * @return Address
     */
    public function default($user): Address;
}
