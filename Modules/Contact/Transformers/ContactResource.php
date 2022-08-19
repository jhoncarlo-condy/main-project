<?php

namespace Modules\Contact\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Contact\Transformers\ContactInfoResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $payload = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'title' => $this->title,
            'contact_infos' => ContactInfoResource::collection($this->contact_infos),
        ];

        return $payload;
    }
}
