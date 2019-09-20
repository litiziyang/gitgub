<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['commit', 'verify', 'wechat']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'sdf';
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function commit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return new BaseResource(400, '参数错误');
        }
        $data = $request->all();

        if (Cache::has($data['phone'])) {
            return new BaseResource(-1, '60秒内仅能获取一次验证码');
        }
        Cache::put($data['phone'], rand(1000, 9999), 60);
        // TODO 发送短信队列 暂时直接返回消息
        return new BaseResource(0, Cache::get($data['phone']));
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'code'  => 'required',
        ]);
        if ($validator->fails()) {
            return new BaseResource(400, '参数错误');
        }
        $data  = $request->all();
        $phone = $data['phone'];
        $code  = $data['code'];

        if (Cache::get($phone) == $code) {
            Cache::forget($phone);

            $user = User::firstOrCreate([
                'phone' => $phone,
            ]);
            if (!$user->name) {
                $user->name = '用户' . $user->phone;
                $user->save();
            }

            $token = $user->getToken();
            return new BaseResource(0, '', [
                'token' => $token,
            ]);
        } else {
            return new BaseResource(-1, '验证码错误');
        }
    }

    public function wechat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return new BaseResource(400, '参数错误');
        }
        $data = $request->all();
        
    }
}
