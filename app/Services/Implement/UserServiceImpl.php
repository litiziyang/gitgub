<?php


namespace App\Services\Implement;


use App\Services\UserService;
use App\User;

class UserServiceImpl implements UserService
{
    protected $userRepository;

    public function __construct(User $user)
    {
        $this->userRepository = $user->query();
    }

    /**
     * 获取指定ID用户信息
     *
     * @param int $user_id
     *
     * @return User
     */
    public function getInfo($user_id): User
    {
        return $this->userRepository->with('avatar')
            ->findOrFail($user_id);
    }

    /**
     * 设置用户默认地址
     *
     * @param int $address_id 地址ID
     *
     * @return mixed
     */
    public function setDefaultAddress($address_id)
    {
        return $this->userRepository->update([
            'default_address_id' => $address_id
        ]);
    }
}
