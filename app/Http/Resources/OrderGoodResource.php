<?php

namespace App\Http\Resources;

use App\OrderGood;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class OrderGoodResource
 * @package App\Http\Resources
 * @mixin OrderGood
 */
class OrderGoodResource extends JsonResource
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
            'title' => $this->title,
            'image'  => config('app.cos.cdn') . $this->image->url,
            'number' => $this->count
        ];
    }
}
