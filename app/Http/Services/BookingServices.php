<?php

namespace App\Http\Services;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class BookingServices
{
    public $booking = null;
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
        DB::transaction(function () use ($validatedData) {
            $event = Event::lockForUpdate()->findOrFail($validatedData['event_id']);
            if ($event->available_seats < $validatedData['quantity']) {
                throw new \Exception('Not enough tickets available');
            }
            $event->decrement('available_seats', $validatedData['quantity']);
            $validatedData['total_price'] = $validatedData['quantity'] * $event->price;
            $this->booking = Booking::create($validatedData);
        });
        if ($this->booking) {
            return $this->booking;
        } else {
            return false;
        }
    }
    public function update($id, $validatedData)
    {
        $booking = $this->getBooking($id);
        if (!$booking) {
            return false;
        }
        $booking->update($validatedData);
        return $booking;
    }
    public function delete($id)
    {
        $booking = $this->getBooking($id);
        if (!$booking) {
            return false;
        }
        return $booking->delete();
    }
}
