<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ride;

class RideController extends Controller
{
    public function index()
    {
        $rides = Ride::with(["passenger", "driver"])
            ->latest()
            ->paginate(20);

        return view("admin.rides.index", compact("rides"));
    }

    public function show(Ride $ride)
    {
        $ride->load(["passenger", "driver", "driverRequests.driver"]);

        return view("admin.rides.show", compact("ride"));
    }
}
