<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RideResource extends JsonResource
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

            "pickup" => [
                "lat" => (float) $this->pickup_lat,
                "lng" => (float) $this->pickup_lng,
            ],

            "destination" => [
                "lat" => (float) $this->destination_lat,
                "lng" => (float) $this->destination_lng,
            ],

            "passenger" => $this->passenger ? [
                "id" => $this->passenger->id,
                "name" => $this->passenger->name,
                "phone" => $this->passenger->phone,
            ] : null,

            "driver" => $this->driver ? [
                "id" => $this->driver->id,
                "name" => $this->driver->name,
                "phone" => $this->driver->phone,
            ] : null,

            "approved_at" => $this->approved_at?->toDateTimeString(),
            "passenger_completed_at" => $this->passenger_completed_at?->toDateTimeString(),
            "driver_completed_at" => $this->driver_completed_at?->toDateTimeString(),

            "created_at" => $this->created_at?->toDateTimeString(),
            "updated_at" => $this->updated_at?->toDateTimeString(),
        ];
    }
}
