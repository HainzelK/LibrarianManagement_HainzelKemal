@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Pending Reservations</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Item</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->inventory->title }}</td>
                        <td>{{ ucfirst($reservation->status) }}</td>
                        <td>
                            @if ($reservation->status == 'pending')
                                <form action="{{ route('reservations.approve', $reservation->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>
                                <form action="{{ route('reservations.reject', $reservation->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            @else
                                <button class="btn btn-secondary" disabled>Processed</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $reservations->links() }}
    </div>
@endsection
