<?php

namespace App\Http\Controllers;

use App\Commodity;
use App\Http\Resources\BaseResource;
use App\Http\Resources\CommodityResource;
use App\Http\Resources\RecordResource;
use App\Services\RecordService;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    protected $recordService;

    public function __construct(RecordService $recordService)
    {
        $this->middleware('jwt', ['except' => []]);
        $this->recordService = $recordService;
    }

    /**
     * 获取浏览历史列表.
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function index(Request $request)
    {
        $history = $this->recordService->getHistory($request->user_id);
        return $this->success(RecordResource::collection($history));
    }

}
