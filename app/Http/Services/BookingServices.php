<?php

namespace App\Http\Services;

use App\Http\Resources\BookingResource;
use App\Models\Booking;

class BookingServices
{
    public function getBookings($per_page)
    {
        return Booking::with(['event', 'user'])->paginate($per_page ?? 5);
    }
    public function getBooking($id)
    {
        return Booking::with(['event', 'user'])->find($id);
    }
    public function create($validatedData)
    {
        return  Booking::create($validatedData);
    }
    public function update($booking, $validatedData)
    {

        return $booking->update($validatedData);
    }
    public function delete($booking)
    {
        return $booking->delete();
    }
}
