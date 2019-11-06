<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 * @mixin User
 */
class UserResource extends JsonResource
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
            'name'     => $this->name,
            'avatar'   => $this->avatar ? config('app.cos.cdn') . $this->avatar->url : null,
            'phone'    => $this->phone,
            'integral' => $this->integral,
            'balance'  => $this->balance,
            'is_member' => $this->member_type
        ];
    }
}
