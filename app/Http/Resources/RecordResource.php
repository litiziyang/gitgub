<?php

namespace App\Http\Resources;

use App\Record;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class RecordResource
 * @package App\Http\Resources
 * @mixin Record
 */
class RecordResource extends JsonResource
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
            'id'    => $this->commodity->id,
            'image' => config('app.cos.cdn') . $this->commodity->bannerImages[0]->url
        ];
    }
}
