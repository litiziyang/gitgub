<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
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
            'id'     => $this->id,
            'url'    => $this->image ? env('COSV5_CDN', '')  . $this->image->url : null,
            'target' => $this->target,
            'level'  => $this->level,
            'color'  => $this->color,
        ];
    }
}
