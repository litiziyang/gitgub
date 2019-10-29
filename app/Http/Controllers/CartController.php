<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Commodity;
use App\Http\Resources\BaseResource;
use App\Http\Resources\CartResource;
use App\Image;
use App\Services\CartService;
use App\Services\CommodityService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Validator;

class CartController extends Controller
{

    protected $commodityService;
    protected $cartService;

    public function __construct(CommodityService $commodityService, CartService $cartService)
    {
        $this->middleware('jwt', ['except' => []]);
        $this->commodityService = $commodityService;
        $this->cartService = $cartService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function index(Request $request)
    {
        $carts = Cart::with('commodity.bannerImages')
            ->where('user_id', $request->user_id)
            ->get();
        return new BaseResource(0, '', CartResource::collection($carts));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->validate();
        }

        $id = $data['id'];
        $commodity = $this->commodityService->getWithImage($id);
        $this->cartService->create($commodity, $request->user_id);

        return $this->success();
    }

    /**
     * Display the specified resource.
     *
     * @param Cart $cart
     *
     * @return Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Cart $cart
     *
     * @return Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Cart    $cart
     *
     * @return BaseResource
     * @throws ValidationException
     */
    public function update(Request $request, Cart $cart)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'count' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return $this->validate();
        }
        $cart->count = $data['count'];
        $cart->save();
        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cart    $cart
     *
     * @param Request $request
     *
     * @return BaseResource
     * @throws Exception
     */
    public function destroy(Cart $cart, Request $request)
    {
        if ($cart->user_id != $request['user_id']) {
            return $this->permission();
        }
        $image = $cart->image;
        if ($image) {
            $image->delete();
        }
        $cart->delete();
        return $this->success();
    }

    public function destroyAll(Request $request)
    {
        $carts = Cart::query()
            ->where('user_id', $request->user_id)
            ->get();
        foreach ($carts as $cart) {
            $image = $cart->image;
            if ($image) {
                $image->delete();
            }
            $cart->delete();
        }
        return $this->success();
    }
}
