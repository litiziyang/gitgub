<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommodityDetailResource extends JsonResource
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
            // 'banners'     => sizeof($this->bannerImages) > 0 ? $this->bannerImages : null,
            'banners'     => [
                ['url' => 'https://img14.360buyimg.com/n0/jfs/t1/54383/6/1829/369982/5cfb31fdEc1b86060/3c4641addc5d8cc6.png'],
                ['url' => 'https://img14.360buyimg.com/n0/jfs/t1624/221/563026929/213456/24db885b/5595ea82N03dda223.jpg'],
                ['url' => 'https://img14.360buyimg.com/n0/jfs/t805/86/1328561956/196105/605f134/5595ea88N71f78318.jpg'],
                ['url' => 'https://img14.360buyimg.com/n0/jfs/t1033/66/1367226612/127020/b0089611/5595ea8cN209f7d99.jpg'],
                ['url' => 'https://img14.360buyimg.com/n0/jfs/t1135/293/1394456851/160900/57c54845/5595ea8fN9a62df04.jpg'],
            ],
            // 'details'     => sizeof($this->detailImages) > 0 ? $this->detailImages : null,
            'details'     => [
                ['url' => 'http://img10.360buyimg.com/imgzone/jfs/t1/38499/28/14613/373275/5d5a4ea6E02ffbd87/f13e1a12af34838f.jpg'],
                ['url' => 'https://img10.360buyimg.com/imgzone/jfs/t1/17785/30/9500/158822/5c80bb44E6750ff9a/0b247d8f186bf07b.jpg'],
            ],
            'cdn'         => env('COSV5_CDN'),
            // 'image'       =>  null,
        ];
    }
}
