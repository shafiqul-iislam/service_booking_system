<?php

namespace App\Services;

use App\Models\Booking;


class BookingService
{
    public function __construct()
    {
        //
    }

    public function getBookings($request)
    {
        // get only login user's/customer bookings
        $bookings = $request->user()->bookings()->with('service')->latest()->get();

        return $bookings;
    }


    public function getAdminBookings()
    {
        $bookings = Booking::with('user', 'service')->latest()->get();

        return $bookings;
    }
}
