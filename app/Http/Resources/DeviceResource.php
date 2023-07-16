<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
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
            'deviceidentifier' => $this->deviceidentifier,
            'organisation' => $this->organisation,
            'verifiedfrom' => $this->verifiedfrom,
            'logcount' => $this->logEntries()->count(),
            'notaknowledgedlogcount' => $this->logEntries()->whereNull("aknowledged_at")->count(),
            'formatted_created_at' => isset($this->created_at) ? $this->created_at->format('d M Y') : "not available",
            'formatted_verified_at' => isset($this->verified_at) ? $this->verified_at->format('d M Y') : "not verified",
            'formatted_last_api_call_date' => isset($this->last_api_call) ? $this->last_api_call->format('d M Y') : "never",
            'formatted_last_api_call_time' => isset($this->last_api_call) ? $this->last_api_call->format('H:i:s') : "",
        ];
    }
}
