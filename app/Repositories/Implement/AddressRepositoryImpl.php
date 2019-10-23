<?php


namespace App\Repositories\Implement;


use App\Address;
use App\Repositories\AddressRepository;

class AddressRepositoryImpl implements AddressRepository
{
    protected $addressModel;

    public function __construct(Address $addressModel)
    {
        $this->addressModel = $addressModel->query();
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
        return $this->addressModel->create($address);
    }
}
