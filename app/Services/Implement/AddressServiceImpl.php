<?php


namespace App\Services\Implement;


use App\Address;
use App\Services\AddressService;
use App\User;

class AddressServiceImpl implements AddressService
{

    protected $addressRepository;

    public function __construct(Address $address)
    {
        $this->addressRepository = $address->query();
    }

    /**
     * 新增地址
     *
     * @param array $address 地址内容
     *
     * @return Address 创建的实例
     */
    public function create(array $address): Address
    {
        return $this->addressRepository->create($address);
    }

    /**
     * 获取单个地址
     *
     * @param integer $id 地址ID
     *
     * @return Address 获取的实例
     */
    public function find($id): Address
    {
        return $this->addressRepository->with('user')
            ->findOrFail($id);
    }

    /**
     * 更新地址
     *
     * @param array   $newAddress 新的地址内容
     * @param Address $oldAddress 旧的地址实例
     *
     * @return boolean 是否成功
     */
    public function update(array $newAddress, Address $oldAddress): bool
    {
        return $oldAddress->update($newAddress);
    }

    /**
     * 获取默认地址
     *
     * @param User $user 用户
     *
     * @return Address|null
     */
    public function default($user)
    {
        if ($user->defaultAddress) {
            return $user->defaultAddress;
        } else {
            return $user->addresses->first();
        }
    }
}
