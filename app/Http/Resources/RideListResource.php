<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RideListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "status" => $this->status,
            "pickup_lat" => (float) $this->pickup_lat,
            "pickup_lng" => (float) $this->pickup_lng,
            "created_at" => $this->created_at?->toDateTimeString(),
        ];
    }
}
