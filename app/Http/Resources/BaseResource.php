<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{

    protected $msg;
    protected $code;
    protected $data;

    public function __construct($data, $code, $msg)
    {
        $this->code = $code;
        $this->msg  = $msg;
        $this->data = $data;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'msg'  => $this->msg,
            'code' => $this->code,
            'data' => $this->data,
        ];
    }
}
