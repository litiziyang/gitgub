<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommodityResource extends JsonResource
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
            'id'          => $this->id,
            'title'       => $this->title,
            'price'       => $this->price,
            'reward'      => $this->reward,
            'count_sales' => $this->count_sales,
            'count_view'  => $this->count_view,
            'count_stack' => $this->count_stack,
            // 'image'       => sizeof($this->bannerImages) > 0 ? env('COSV5_CDN') . '/' . $this->bannerImages[0]->url : null,
            'image'       =>  null,
        ];
    }
}
