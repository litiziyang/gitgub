<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'title' => $this->commodity ? $this->commodity->title : $this->title,
            'price' => $this->commodity ? $this->commodity->price : $this->price,
            'count' => $this->count,
            // 'image' => env('COSV5_CDN','') . ($this->commodity ? $this->commodity->bannerImages[0]->url : $this->image),
            'image' => 'https://img14.360buyimg.com/n0/jfs/t1/54383/6/1829/369982/5cfb31fdEc1b86060/3c4641addc5d8cc6.png',
        ];
    }
}
