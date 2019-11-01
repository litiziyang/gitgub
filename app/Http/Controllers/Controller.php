<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 权限不足的返回
     * @return BaseResource
     */
    public function permission(): BaseResource
    {
        return new BaseResource(403, '权限不足');
    }

    /**
     * 成功的返回
     *
     * @param mixed|null $data
     *
     * @return BaseResource
     */
    public function success($data = null): BaseResource
    {
        return new BaseResource(0, '', $data);
    }

    /**
     * 请求验证失败的返回
     *
     * @param mixed|null $data
     *
     * @return BaseResource
     */
    public function validate($data = null): BaseResource
    {
        return new BaseResource(400, '参数错误', $data);
    }
}
