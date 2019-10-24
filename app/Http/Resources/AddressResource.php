<?php

namespace App\Http\Resources;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AddressResource
 * @package App\Http\Resources
 * @mixin Address
 */
class AddressResource extends JsonResource
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
            'name'        => $this->name,
            'phone'       => $this->phone,
            'address'     => $this->address,
            'description' => $this->description,
            'longitude'   => $this->longitude,
            'latitude'    => $this->latitude,
            'default'     => $this->user->default_address_id === $this->id
        ];
    }
}
