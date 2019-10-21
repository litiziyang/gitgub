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

    public function permission(): BaseResource
    {
        return new BaseResource(403, '权限不足');
    }

    public function success(): BaseResource
    {
        return new BaseResource(0, '');
    }

    public function validate(): BaseResource
    {
        return new BaseResource(400, '参数错误');
    }
}
