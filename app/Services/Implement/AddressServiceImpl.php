<?php


namespace App\Services\Implement;


use App\Address;
use App\Repositories\AddressRepository;
use App\Services\AddressService;

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
}
