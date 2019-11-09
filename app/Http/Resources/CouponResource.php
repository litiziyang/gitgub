<?php

namespace App\Http\Resources;
use App\Coupon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CouponResource
 * @package App\Http\Resources
 * @mixin Coupon
 */
class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'       => $this->name,
            'expire'     => strtotime($this->expire),
            'offer'      => $this->offer,
            'condition'  => $this->condition,
        ];
    }
}
