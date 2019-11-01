<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Http\Resources\BannerResource;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return BaseResource
     */
    public function index()
    {
        $banners = Banner::with('image')
            ->orderBy('level', 'desc')
            ->get();
        return $this->success(BannerResource::collection($banners));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Banner $banner
     *
     * @return Response
     */
    public function edit(Banner $banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Banner  $banner
     *
     * @return Response
     */
    public function update(Request $request, Banner $banner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Banner $banner
     *
     * @return Response
     */
    public function destroy(Banner $banner)
    {
        //
    }
}
