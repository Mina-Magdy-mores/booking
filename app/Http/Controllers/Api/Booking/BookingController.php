<?php

namespace App\Http\Controllers\Api\Booking;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Services\BookingServices;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public BookingServices $bookingServices;
    public function __construct()
    {
        $this->bookingServices = new BookingServices();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bookings = $this->bookingServices->getBookings($request->per_page);
       if (!$bookings) {
            return response()->json([
                'status' => false,
                'message' => 'Bookings not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'bookings' => BookingResource::collection($bookings)->response()->getData(true)
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $booking = $this->bookingServices->getBooking($id);
        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'booking' => new BookingResource($booking)
        ], 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
