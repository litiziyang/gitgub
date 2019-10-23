<?php

namespace App\Http\Resources;

use App\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BannerResource
 * @package App\Http\Resources
 * @mixin Banner
 */
class BannerResource extends JsonResource
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
            'id'     => $this->id,
            'url'    => $this->image ? config('app.cos.cdn') . $this->image->url : null,
            'target' => $this->target,
            'level'  => $this->level,
            'color'  => $this->color,
        ];
    }
}
