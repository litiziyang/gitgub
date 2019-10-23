<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Resources\AddressResource;
use App\Http\Resources\BaseResource;
use App\Services\AddressService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Validator;

class AddressController extends Controller
{
    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->middleware('jwt', ['except' => []]);
        $this->addressService = $addressService;
    }

    /**
     * 获取地址列表.
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function index(Request $request)
    {
        $addresses = Address::where('user_id', $request['user_id'])
            ->get();
        return $this->success(AddressResource::collection($addresses));
    }

    /**
     * 新增地址.
     *
     * @param Request $request
     *
     * @return BaseResource
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name'        => 'required|string',
            'phone'       => 'required|min:11',
            'address'     => 'required|string',
            'description' => 'required|string',
            'longitude'   => 'sometimes|string',
            'latitude'    => 'sometimes|string',
        ]);
        if ($validator->fails()) {
            return $this->validate();
        }

        $data['user_id'] = $request['user_id'];
        $address = $this->addressService->create($data);
        return $this->success($address);
    }

    /**
     * 获取单个地址
     *
     * @param Address $address
     *
     * @return BaseResource
     */
    public function show(Address $address)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Address $address
     *
     * @return Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Address $address
     *
     * @return Response
     */
    public function destroy(Address $address)
    {
        //
    }
}
