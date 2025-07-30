<?php

namespace App\Http\Controllers\Api\Booking;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;

class BookingController extends Controller
{

    public function index(Request $request)
    {
        // get only login user's bookings
        $bookings = $request->user()->bookings()->with('service')->latest()->get();

        return response()->json([
            'bookings' => $bookings
        ]);
    }


    public function store(StoreBookingRequest $request)
    {
        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
            'status' => 0,
        ]);

        return response()->json([
            'message' => 'Booking successful',
            'booking' => $booking 
        ], 201);
    }
}
