<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Http\Resources\BaseResource;
use App\Http\Resources\CouponResource;
use Illuminate\Http\Request;
use App\Services\CouponService;
use Validator;

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
        $this->middleware('jwt', ['except' => []]);
    }

    /**  根据用户id获取到优惠券
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function index(Request $request)
    {
        $coupon = $this->couponService->getCoupon($request->user_id);
        return new BaseResource(0, "", CouponResource::collection($coupon));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return BaseResource
     */
    public function store(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'share_id'  => 'required|integer',
            'offer'     => 'required|integer',
            'condition' => 'required|string',
            'new'       => 'required|integer',
        ]);
        if ($validator->failed()) {
            return $this->validate();
        }
        $coupon = $this->couponService->createCoupon($data['offer'], $data['share_id'], $data['condition'], $data['new']);
        return $this->success(new CouponResource($coupon));

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request     $request
     * @param \App\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        //
    }
}
