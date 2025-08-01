<?php

namespace App\Http\Controllers\Api\Booking;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Services\BookingService;

class BookingController extends Controller
{
    public function __construct(
        private BookingService $bookingServices
    ) {}


    public function index(Request $request)
    {
        // customer's bookings
        $bookings = $this->bookingServices->getBookings($request);

        return response()->json([
            'bookings' => $bookings
        ]);
    }

    // booking for customer
    public function store(StoreBookingRequest $request)
    {
        try {
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
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // for admin
    public function adminIndex()
    {
        $bookings = $this->bookingServices->getAdminBookings();

        return response()->json([
            'bookings' => $bookings
        ]);
    }
}
