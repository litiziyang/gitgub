<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Resources\AddressResource;
use Illuminate\Http\Request;
use Validator;

class AddressController extends Controller
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
    public function index(Request $request)
    {
        $addresses = Address::where('user_id', $request->user_id)
            ->get();
        return $this->success(AddressResource::collection($addresses));
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
        $data = $request->all();

        $validator = Validator::make($data, [
            'name'        => 'required|string',
            'phone'       => 'required|min:11',
            'address'     => 'required|string',
            'description' => 'required|string',
            'longitude'   => 'sometimes|string',
            'latitide'    => 'sometimes|string',
        ]);
        if ($validator->fails()) {
            return $this->validate();
        }

        $data->user_id = $request->user_id;
        Address::Create();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }
}
