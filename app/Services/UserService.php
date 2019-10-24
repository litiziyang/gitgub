<?php


namespace App\Services;


use App\User;

interface UserService
{
    /**
     * 获取指定ID用户信息
     *
     * @param int $user_id
     *
     * @return User
     */
    public function getInfo($user_id): User;

    /**
     * 设置用户默认地址
     *
     * @param int $address_id 地址ID
     *
     * @return mixed
     */
    public function setDefaultAddress($address_id);
}
