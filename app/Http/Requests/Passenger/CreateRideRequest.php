<?php

namespace App\Http\Requests\Passenger;

use Illuminate\Foundation\Http\FormRequest;

class CreateRideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "passenger_id" => ["required", "exists:passengers,id"],

            "pickup_lat" => ["required", "numeric", "between:-90,90"],
            "pickup_lng" => ["required", "numeric", "between:-180,180"],

            "destination_lat" => ["required", "numeric", "between:-90,90"],
            "destination_lng" => ["required", "numeric", "between:-180,180"],
        ];
    }
}
