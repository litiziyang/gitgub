<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Resources\AddressResource;
use App\Http\Resources\BaseResource;
use App\Services\AddressService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Validator;

class AddressController extends Controller
{
    protected $addressService;
    protected $userService;

    public function __construct(AddressService $addressService, UserService $userService)
    {
        $this->middleware('jwt', ['except' => []]);
        $this->addressService = $addressService;
        $this->userService = $userService;
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
     * @throws Exception
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name'        => 'required|string',
            'phone'       => 'required|min:11',
            'address'     => 'required|string',
            'description' => 'required|string',
            'longitude'   => 'required',
            'latitude'    => 'required',
            'default'     => 'required'
        ]);
        if ($validator->fails()) {
            return $this->validate();
        }

        $data['user_id'] = $request['user_id'];
        \DB::beginTransaction();
        $address = $this->addressService->create($data);
        if ($data['default'] == true) {
            $this->userService->setDefaultAddress($address->id);
        }
        \DB::commit();
        return $this->success($address);
    }

    /**
     * 获取单个地址.
     *
     * @param $id
     *
     * @return BaseResource
     */
    public function show($id)
    {
        $address = $this->addressService->find($id);
        return $this->success(new AddressResource($address));
    }

    /**
     * 更新地址.
     *
     * @param Request $request
     * @param Address $address
     *
     * @return BaseResource
     */
    public function update(Request $request, Address $address)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name'        => 'required|string',
            'phone'       => 'required|min:11',
            'address'     => 'required|string',
            'description' => 'required|string',
            'longitude'   => 'required',
            'latitude'    => 'required',
            'default'     => 'required'
        ]);
        if ($validator->fails()) {
            return $this->validate();
        }
        if ($address->user_id != $request->user_id) {
            return $this->permission();
        }
        $this->addressService->update($data, $address);
        if ($data['default'] == true) {
            $this->userService->setDefaultAddress($address->id);
        }
        return $this->success();
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

    /**
     * 获取默认地址
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function default(Request $request)
    {
        $user = $this->userService->getInfo($request->user_id);
        $defaultAddress = $this->addressService->default($user);
        if (!$defaultAddress) {
            return $this->success();
        }
        return $this->success(new AddressResource($defaultAddress));
    }
}
