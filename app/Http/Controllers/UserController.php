<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\User;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Illuminate\Http\Request;
use Cache;
use Storage;
use Validator;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('jwt', ['except' => ['commit', 'verify', 'wechat']]);
    }

    /**
     * 获取自身信息.
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function index(Request $request)
    {
        $user = $this->userService->getInfo($request->user_id);
        return new BaseResource(0, '', new UserResource($user));
    }

    /**
     * 开通会员服务
     * @param Request $request
     *
     * @return BaseResource
     */
    public function makeVip(Request $request)
    {
        $user = $this->userService->setVip($request->user_id, $request->user_status);
        if ($user) {
            return $this->success([
                'msg' => '开通成功'
            ]);
        } else {
            return new BaseResource(1, '失败，请重试');
        }

    }

    /**
     * 获取他人信息.
     *
     * @param int $id
     *
     * @return BaseResource
     */
    public function show($id)
    {
        $user = $this->userService->getInfo($id);
        return new BaseResource(0, '', new UserResource($user));
    }

    /**
     * @param Request $request
     *
     * @return BaseResource
     */
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

    /**
     * 登录信息提交，返回验证码
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function commit(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return new BaseResource(400, '参数错误');
        }


        if (Cache::has($data['phone'])) {
            return new BaseResource(-1, '60秒内仅能获取一次验证码');
        }
        Cache::put($data['phone'], rand(1000, 9999), 60);
        // TODO 发送短信队列 暂时直接返回消息
        return new BaseResource(0, Cache::get($data['phone']));
    }

    /**
     * 验证登录
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function verify(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'phone' => 'required',
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return new BaseResource(400, '参数错误');
        }
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

    /**
     * 微信登录接口
     *
     * @param Request $request
     *
     * @return BaseResource
     * @throws InvalidConfigException
     */
    public function wechat(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'code' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return new BaseResource(400, '参数错误');
        }
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

    /**
     * 获取cos临时密钥
     * @return BaseResource
     */
    public function secret()
    {
        $disk = Storage::disk('cosv5');
        return new BaseResource(0, '', $disk->getFederationTokenV3('*', 7200, null, 'cos'));
    }
}
