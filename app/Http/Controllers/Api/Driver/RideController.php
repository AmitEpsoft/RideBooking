<?php

namespace App\Http\Controllers\Api\Driver;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Driver\CompleteRideRequest;
use App\Http\Requests\Driver\RequestRideRequest;
use App\Http\Resources\RideResource;
use App\Models\Ride;
use App\Models\RideDriverRequest;

class RideController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/driver/rides/{ride}/request",
     *     summary="Driver requests/claims a ride",
     *     tags={"Driver"},
     *     @OA\Parameter(name="ride", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"driver_id"},
     *             @OA\Property(property="driver_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Ride requested")
     * )
     */
    public function requestRide(RequestRideRequest $request, Ride $ride)
    {
        if (!in_array($ride->status, ["pending", "claimed"])) {
            return ApiResponse::error("Ride cannot be requested in current status", null, 422);
        }

        if ($ride->driver_id) {
            return ApiResponse::error("Ride already has approved driver", null, 422);
        }

        $driverRequest = RideDriverRequest::firstOrCreate(
            ["ride_id" => $ride->id, "driver_id" => $request->driver_id],
            ["status" => "requested"]
        );

        if ($ride->status === "pending") {
            $ride->update(["status" => "claimed"]);
        }

        $ride->load(["passenger", "driver"]);

        return ApiResponse::success([
            "driver_request" => $driverRequest,
            "ride" => new RideResource($ride)
        ], "Ride requested successfully");
    }

    /**
     * @OA\Post(
     *     path="/api/driver/rides/{ride}/complete",
     *     summary="Driver marks ride as completed",
     *     tags={"Driver"},
     *     @OA\Parameter(name="ride", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"driver_id"},
     *             @OA\Property(property="driver_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Driver completed")
     * )
     */
    public function complete(CompleteRideRequest $request, Ride $ride)
    {
        if (!$ride->driver_id) {
            return ApiResponse::error("Ride has no approved driver yet", null, 422);
        }

        if ($ride->driver_id != $request->driver_id) {
            return ApiResponse::error("This ride is not assigned to this driver", null, 403);
        }

        if ($ride->status === "completed") {
            return ApiResponse::error("Ride already completed", null, 422);
        }

        $ride->update([
            "driver_completed_at" => now(),
        ]);

        if ($ride->isFullyCompleted()) {
            $ride->update(["status" => "completed"]);
        }

        $ride->refresh()->load(["passenger", "driver"]);

        return ApiResponse::success(new RideResource($ride), "Driver marked ride as completed");
    }
}
