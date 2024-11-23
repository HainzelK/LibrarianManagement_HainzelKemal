<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ReservationController extends Controller
{
    /**
     * Apply the middleware to ensure only librarians can access the routes in this controller.
     */
    public function __construct()
    {
        // Middleware is applied in the controller constructor
        $this->middleware('role:librarian'); 
    }

    /**
     * Show the list of pending reservations to the librarian.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all pending reservations, paginated for easier navigation
        $reservations = Reservation::where('status', 'pending')->latest()->paginate(10);

        // Return the view with the pending reservations
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Approve a reservation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Only approve if the status is pending
        if ($reservation->status === 'pending') {
            $reservation->status = 'approved';
            $reservation->save();
            
            // Redirect back with a success message
            return redirect()->route('reservations.index')->with('success', 'Reservation approved.');
        }

        // Redirect back with an error message if reservation is already processed
        return redirect()->route('reservations.index')->with('error', 'Reservation is already processed.');
    }

    /**
     * Reject a reservation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Only reject if the status is pending
        if ($reservation->status === 'pending') {
            $reservation->status = 'rejected';
            $reservation->save();
            
            // Redirect back with a success message
            return redirect()->route('reservations.index')->with('success', 'Reservation rejected.');
        }

        // Redirect back with an error message if reservation is already processed
        return redirect()->route('reservations.index')->with('error', 'Reservation is already processed.');
    }
}
