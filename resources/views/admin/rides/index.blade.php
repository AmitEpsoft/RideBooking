@extends("admin.layout")

@section("content")
<div class="card">
    <h3>All Rides</h3>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Passenger</th>
            <th>Driver</th>
            <th>Status</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rides as $ride)
            <tr>
                <td>#{{ $ride->id }}</td>
                <td>{{ $ride->passenger?->name ?? "-" }}</td>
                <td>{{ $ride->driver?->name ?? "-" }}</td>
                <td>
                    <span class="badge {{ $ride->status }}">{{ strtoupper($ride->status) }}</span>
                </td>
                <td>{{ $ride->created_at }}</td>
                <td>
                    <a href="{{ route('admin.rides.show', $ride->id) }}">View</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:15px;">
        {{ $rides->links() }}
    </div>
</div>
@endsection
