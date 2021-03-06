<?php

namespace App\Http\Resources;

use App\Commodity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CommodityResource
 * @package App\Http\Resources
 * @mixin Commodity
 */
class CommodityResource extends JsonResource
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
            'title'       => $this->title,
            'price'       => $this->price,
            'reward'      => $this->reward,
            'count_sales' => $this->count_sales,
            'count_view'  => $this->count_view,
            'count_stack' => $this->count_stack,
//            'image'       => sizeof($this->bannerImages) > 0 ? config('app.cos.cdn') . $this->bannerImages[0]->url : null,
                        'image'       => 'https://img14.360buyimg.com/n0/jfs/t1/54383/6/1829/369982/5cfb31fdEc1b86060/3c4641addc5d8cc6.png'
        ];
    }
}
