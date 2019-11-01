<?php

namespace App\Http\Controllers;

use App\Commodity;
use App\Http\Resources\BaseResource;
use App\Http\Resources\CommodityDetailResource;
use App\Http\Resources\CommodityResource;
use App\Services\CommodityService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class CommodityController extends Controller
{

    protected $commodityService;

    public function __construct(CommodityService $commodityService)
    {
        $this->middleware('jwt', ['except' => ['index', 'home', 'show']]);
        $this->commodityService = $commodityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return BaseResource
     */
    public function index()
    {
        $commodities = Commodity::with('bannerImages');
        // ->where('count_stack', '>', '0');
        $category_id = request()->category_id;
        $order_by = request()->order_by;
        $order_type = request()->order_type;

        if ($category_id != null) {
            $commodities->where('category_id', $category_id);
        }
        if ($order_by != null && $order_type != null) {
            $commodities->orderBy($order_by, $order_type);
        } else {
            $commodities->orderBy('count_sales', 'desc');
        }
        $commodities = $commodities->paginate(18);
        return $this->success(CommodityResource::collection($commodities));
    }

    /**
     * 获取Home界面的商品
     * @return BaseResource
     */
    public function home()
    {
        $commodities = Commodity::with('bannerImages')
            // ->where('count_stack', '>', '0')
            ->orderBy('count_sales', 'desc')
            ->take(18)
            ->get();
        return $this->success(CommodityResource::collection($commodities));
    }


    /**
     * 获取单个商品.
     *
     * @param Commodity $commodity
     *
     * @return BaseResource
     */
    public function show(Commodity $commodity)
    {
        return $this->success(new CommodityDetailResource($commodity));
    }

    /**
     * @param Request $request
     *
     * @return BaseResource
     */
    public function commodities(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'commodities' => 'required|array',
        ]);
        if ($validator->fails()) {
            return $this->validate();
        }
        if (sizeof($data['commodities']) > 1) {
            $commodities = $this->commodityService->listByCart($data['commodities']);
        } else {
            $commodities = $this->commodityService->list($data['commodities'][0]);
        }
        return $this->success(CommodityResource::collection($commodities));
    }
}
