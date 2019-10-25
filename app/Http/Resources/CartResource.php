<?php

namespace App\Http\Resources;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CartResource
 * @package App\Http\Resources
 * @mixin Cart
 */
class CartResource extends JsonResource
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
            'id'    => $this->id,
            'title' => $this->commodity ? $this->commodity->title : $this->title,
            'price' => $this->commodity ? $this->commodity->price : $this->price,
            'count' => $this->count,
            //            'image' => config('app.cos.cdn') . ($this->commodity ? $this->commodity->bannerImages[0]->url : $this->image),
            'image' => 'https://img14.360buyimg.com/n0/jfs/t1/54383/6/1829/369982/5cfb31fdEc1b86060/3c4641addc5d8cc6.png',
        ];
    }
}
