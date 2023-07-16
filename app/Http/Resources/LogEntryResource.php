<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogEntryResource extends JsonResource
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
            'source' => $this->source,
            'class' => $this->class,
            'device' => $this->device,
            'content' => $this->content,
            'aknowledged_from' => $this->aknowledged_from,
            'formatted_aknowledged_at' => isset($this->aknowledged_at) ? $this->aknowledged_at->format('d M Y') : "not aknowledged",
            'formatted_created_at' => $this->created_at->format('d M Y'),
        ];
    }
}
