<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['commit', 'verify', 'wechat']]);
    }

    /**
     * 获取用户信息.
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function index(Request $request)
    {
        $user = User::with('avatar')
            ->findOrFail($request['user_id']);
        return new BaseResource(0, '', new UserResource($user));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|min:2|max:12',
        ]);
        if ($validator->fails()) {
            return new BaseResource(400, '昵称为2到12位的中英文数字组合', $validator->errors());
        }
        $user = User::findOrFail($request['user_id']);
        $user->name = $data['name'];
        $user->save();
        return new BaseResource(0, '更新成功');
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
        $data = $request->all();
        $phone = $data['phone'];
        $code = $data['code'];

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
            'code'  => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return new BaseResource(400, '参数错误');
        }
        $data = $request->all();
        $code = $data['code'];
        $app = User::getWechatApp();
        $res = $app->auth->session($code);
        if (!$res['openid']) {
            return new BaseResource(-1, '微信授权登录失败，请使用手机号或稍后再试');
        } else {
            $user = User::firstOrNew([
                // 'open_id' => $res['openid'],
                'phone' => $data['phone'],
            ]);
            if ($user->open_id != null && $user->open_id != $res['openid']) {
                return new BaseResource(-1, '该手机号已绑定其他微信');
            }
            $user->open_id = $res['openid'];
            $user->save();
            $token = $user->getToken();
            return new BaseResource(0, '', [
                'token' => $token,
            ]);
        }
    }

    public function secret()
    {
        $disk = Storage::disk('cosv5');
        return new BaseResource(0, '', $disk->getFederationTokenV3('*', 7200, null, 'cos'));
    }
}
