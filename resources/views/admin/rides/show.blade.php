@extends("admin.layout")

@section("content")
<div class="card">
    <h3>Ride Details (#{{ $ride->id }})</h3>

    <p><b>Status:</b> <span class="badge {{ $ride->status }}">{{ strtoupper($ride->status) }}</span></p>

    <hr>

    <h4>Passenger</h4>
    <p>
        <b>ID:</b> {{ $ride->passenger?->id }} <br>
        <b>Name:</b> {{ $ride->passenger?->name }} <br>
        <b>Phone:</b> {{ $ride->passenger?->phone }}
    </p>

    <h4>Driver</h4>
    <p>
        <b>ID:</b> {{ $ride->driver?->id ?? "-" }} <br>
        <b>Name:</b> {{ $ride->driver?->name ?? "-" }} <br>
        <b>Phone:</b> {{ $ride->driver?->phone ?? "-" }}
    </p>

    <hr>

    <h4>Coordinates</h4>
    <p>
        <b>Pickup:</b> {{ $ride->pickup_lat }}, {{ $ride->pickup_lng }} <br>
        <b>Destination:</b> {{ $ride->destination_lat }}, {{ $ride->destination_lng }}
    </p>

    <hr>

    <h4>Ride Completion</h4>
    <p>
        <b>Passenger Completed:</b> {{ $ride->passenger_completed_at ?? "-" }} <br>
        <b>Driver Completed:</b> {{ $ride->driver_completed_at ?? "-" }} <br>
        <b>Approved At:</b> {{ $ride->approved_at ?? "-" }}
    </p>

    <hr>

    <h4>Driver Requests</h4>
    <table>
        <thead>
        <tr>
            <th>Driver</th>
            <th>Status</th>
            <th>Requested At</th>
        </tr>
        </thead>
        <tbody>
        @foreach($ride->driverRequests as $req)
            <tr>
                <td>{{ $req->driver?->name }} (#{{ $req->driver_id }})</td>
                <td>{{ strtoupper($req->status) }}</td>
                <td>{{ $req->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <br>
    <a href="{{ route('admin.rides.index') }}">← Back</a>
</div>
@endsection
