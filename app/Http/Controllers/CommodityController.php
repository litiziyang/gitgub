<?php

namespace App\Http\Controllers;

use App\Commodity;
use App\Http\Resources\BaseResource;
use App\Http\Resources\CommodityDetailResource;
use App\Http\Resources\CommodityResource;
use Illuminate\Http\Request;

class CommodityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commodities = Commodity::with('bannerImages');
        // ->where('count_stack', '>', '0');
        $category_id = request()->category_id;
        $order_by    = request()->order_by;
        $order_type  = request()->order_type;

        if ($category_id != null) {
            $commodities->where('category_id', $category_id);
        }
        if ($order_by != null && $order_by != null) {
            $commodities->orderBy($order_by, $order_type);
        } else {
            $commodities->orderBy('count_sales', 'desc');
        }
        $commodities = $commodities->paginate(18);
        return new BaseResource(0, '', CommodityResource::collection($commodities));
    }

    public function home()
    {
        $commodities = Commodity::with('bannerImages')
        // ->where('count_stack', '>', '0')
            ->orderBy('count_sales', 'desc')
            ->take(18)
            ->get();
        return new BaseResource(0, '', CommodityResource::collection($commodities));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function show(Commodity $commodity)
    {
        return new BaseResource(0, '', new CommodityDetailResource($commodity));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function edit(Commodity $commodity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commodity $commodity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commodity $commodity)
    {
        //
    }
}
