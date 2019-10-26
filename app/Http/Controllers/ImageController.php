<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Image;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Validator;

class ImageController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt', ['except' => []]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Image $image
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Image               $image
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Image $image
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }

    /**
     * @param Request $request
     *
     * @return BaseResource
     * @throws Exception
     */
    public function avatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required',
        ]);
        if ($validator->fails()) {
            return new BaseResource(400, '参数错误');
        }
        $data = $request->all();
        $url = $data['url'];
        $user = User::findOrFail($request->user_id);
        if ($user->avatar) {
            $user->avatar->delete();
        }
        Image::firstOrCreate([
            'url'        => $url,
            'image_type' => 'user',
            'image_id'   => $request->user_id,
        ]);
        return new BaseResource(0, '');
    }
}
