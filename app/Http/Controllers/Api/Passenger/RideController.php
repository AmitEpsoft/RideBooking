<?php

namespace App\Http\Controllers\Api\Passenger;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Passenger\ApproveDriverRequest;
use App\Http\Requests\Passenger\CompleteRideRequest;
use App\Http\Requests\Passenger\CreateRideRequest;
use App\Http\Resources\RideResource;
use App\Models\Ride;
use App\Models\RideDriverRequest;
use Illuminate\Support\Facades\DB;

class RideController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/passenger/rides",
     *     summary="Create Ride Request",
     *     tags={"Passenger"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"passenger_id","pickup_lat","pickup_lng","destination_lat","destination_lng"},
     *             @OA\Property(property="passenger_id", type="integer", example=1),
     *             @OA\Property(property="pickup_lat", type="number", example=26.8467),
     *             @OA\Property(property="pickup_lng", type="number", example=80.9462),
     *             @OA\Property(property="destination_lat", type="number", example=26.9124),
     *             @OA\Property(property="destination_lng", type="number", example=75.7873)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Ride created")
     * )
     */
    public function store(CreateRideRequest $request)
    {
        $ride = Ride::create([
            "passenger_id" => $request->passenger_id,
            "pickup_lat" => $request->pickup_lat,
            "pickup_lng" => $request->pickup_lng,
            "destination_lat" => $request->destination_lat,
            "destination_lng" => $request->destination_lng,
            "status" => "pending",
        ]);

        $ride->load(["passenger", "driver"]);

        return ApiResponse::success(new RideResource($ride), "Ride request created");
    }

    /**
     * @OA\Post(
     *     path="/api/passenger/rides/{ride}/approve-driver",
     *     summary="Approve driver for a ride",
     *     tags={"Passenger"},
     *     @OA\Parameter(
     *         name="ride",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"passenger_id","driver_id"},
     *             @OA\Property(property="passenger_id", type="integer", example=1),
     *             @OA\Property(property="driver_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Driver approved")
     * )
     */
    public function approveDriver(ApproveDriverRequest $request, Ride $ride)
    {
        if ($ride->passenger_id != $request->passenger_id) {
            return ApiResponse::error("This ride does not belong to this passenger", null, 403);
        }

        if ($ride->status !== "pending" && $ride->status !== "claimed") {
            return ApiResponse::error("Ride cannot be approved in current status", null, 422);
        }

        $driverRequest = RideDriverRequest::where("ride_id", $ride->id)
            ->where("driver_id", $request->driver_id)
            ->first();

        if (!$driverRequest) {
            return ApiResponse::error("This driver has not requested this ride", null, 422);
        }

        DB::transaction(function () use ($ride, $driverRequest, $request) {
            RideDriverRequest::where("ride_id", $ride->id)->update(["status" => "rejected"]);

            $driverRequest->update(["status" => "approved"]);

            $ride->update([
                "driver_id" => $request->driver_id,
                "status" => "approved",
                "approved_at" => now(),
            ]);
        });

        $ride->refresh()->load(["passenger", "driver"]);

        return ApiResponse::success(new RideResource($ride), "Driver approved successfully");
    }

    /**
     * @OA\Post(
     *     path="/api/passenger/rides/{ride}/complete",
     *     summary="Passenger marks ride as completed",
     *     tags={"Passenger"},
     *     @OA\Parameter(
     *         name="ride",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"passenger_id"},
     *             @OA\Property(property="passenger_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Passenger completed")
     * )
     */
    public function complete(CompleteRideRequest $request, Ride $ride)
    {
        if ($ride->passenger_id != $request->passenger_id) {
            return ApiResponse::error("This ride does not belong to this passenger", null, 403);
        }

        if (!$ride->driver_id) {
            return ApiResponse::error("Ride has no approved driver yet", null, 422);
        }

        if (in_array($ride->status, ["completed"])) {
            return ApiResponse::error("Ride already completed", null, 422);
        }

        $ride->update([
            "passenger_completed_at" => now(),
        ]);

        if ($ride->isFullyCompleted()) {
            $ride->update(["status" => "completed"]);
        }

        $ride->refresh()->load(["passenger", "driver"]);

        return ApiResponse::success(new RideResource($ride), "Passenger marked ride as completed");
    }
}

