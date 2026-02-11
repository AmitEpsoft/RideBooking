<?php

namespace App\Http\Controllers\Api\Driver;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Driver\NearbyRidesRequest;
use App\Http\Requests\Driver\UpdateLocationRequest;
use App\Http\Resources\RideListResource;
use App\Models\DriverLocation;
use App\Models\Ride;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/driver/location",
     *     summary="Update driver location",
     *     tags={"Driver"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"driver_id","lat","lng"},
     *             @OA\Property(property="driver_id", type="integer", example=1),
     *             @OA\Property(property="lat", type="number", example=26.8467),
     *             @OA\Property(property="lng", type="number", example=80.9462)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Location updated")
     * )
     */
    public function updateLocation(UpdateLocationRequest $request)
    {
        DriverLocation::updateOrCreate(
            ["driver_id" => $request->driver_id],
            ["lat" => $request->lat, "lng" => $request->lng]
        );

        return ApiResponse::success(null, "Driver location updated");
    }

    /**
     * @OA\Get(
     *     path="/api/driver/rides/nearby",
     *     summary="Fetch nearby pending rides",
     *     tags={"Driver"},
     *     @OA\Parameter(name="driver_id", in="query", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="radius_km", in="query", required=true, @OA\Schema(type="number")),
     *     @OA\Response(response=200, description="Nearby rides fetched")
     * )
     */
    public function nearbyRides(NearbyRidesRequest $request)
    {
        $location = DriverLocation::where("driver_id", $request->driver_id)->first();

        if (!$location) {
            return ApiResponse::error("Driver location not found. Send location first.", null, 422);
        }

        $radiusKm = $request->radius_km;

        // Haversine formula in SQL (MySQL)
        $rides = Ride::query()
            ->whereIn("status", ["pending", "claimed"])
            ->whereNull("driver_id") // no approved driver
            ->select("*")
            ->selectRaw("
                (
                    6371 * acos(
                        cos(radians(?)) * cos(radians(pickup_lat)) *
                        cos(radians(pickup_lng) - radians(?)) +
                        sin(radians(?)) * sin(radians(pickup_lat))
                    )
                ) AS distance_km
            ", [$location->lat, $location->lng, $location->lat])
            ->having("distance_km", "<=", $radiusKm)
            ->orderBy("distance_km", "asc")
            ->limit(50)
            ->get();

        return ApiResponse::success(RideListResource::collection($rides), "Nearby rides fetched");
    }
}
