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
            'content' => str_replace("\\n","\n\n",$this->content),
            'acknowledgedfrom' => $this->acknowledgedfrom,
            'formatted_acknowledged_at' => isset($this->acknowledged_at) ? $this->acknowledged_at->format('d M Y') : "not acknowledged",
            'formatted_created_at' => $this->created_at->format('d M Y'),
        ];
    }
}
