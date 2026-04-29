<?php

namespace App\Http\Controllers\Api\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\UpdateBookingRequest;
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
    public function store(BookingRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        $booking = $this->bookingServices->create($validatedData);
        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create booking'
            ], 500);
        }
        return response()->json([
            'status' => true,
            'booking' => new BookingResource($booking->refresh())
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
    public function update(UpdateBookingRequest $request, string $id)
    {
        $booking = $this->bookingServices->getBooking($id);
        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found'
            ], 404);
        }
        $validatedData = $request->validated();
        $booking = $this->bookingServices->update($id, $validatedData);
        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update booking'
            ], 500);
        }
        return response()->json([
            'status' => true,
            'booking' => new BookingResource($booking)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $booking = $this->bookingServices->getBooking($id);
        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found'
            ], 404);
        }
        $booking = $this->bookingServices->delete($id);
        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete booking'
            ], 500);
        }
        return response()->json([
            'status' => true,
            'message' => 'Booking deleted successfully'
        ], 200);
    }
}
