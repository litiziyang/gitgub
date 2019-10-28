<?php

namespace App\Http\Resources;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class OrderResource
 * @package App\Http\Resources
 * @mixin Order
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'time'        => $this->created_at->toDateTimeString(),
            'number'      => $this->number,
            'commodities' => OrderGoodResource::collection($this->orderGood),
            'state'       => $this->state,
            'price'       => $this->price,
        ];
    }
}
