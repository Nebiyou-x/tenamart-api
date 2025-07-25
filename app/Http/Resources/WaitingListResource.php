<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WaitingListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
   {
    return [
        'id' => $this->id,
        'name' => $this->name,
        'email' => $this->email,
        'signup_source' => $this->signup_source,
        'created_at' => $this->created_at->toDateTimeString()
    ];
    }
}
