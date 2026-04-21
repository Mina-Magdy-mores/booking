<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::get();
        if (!$events) {
            return response()->json([
                'status' => false,
                'message' => 'Events not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'events' => EventResource::collection($events),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEventRequest $request)
    {
        $validatedData = $request->validated();
        $event = Event::create($validatedData);
        if (!$event) {
            return response()->json([
                'status' => false,
                'message' => 'Event not created'
            ], 500);
        }
        $event->addMedia($request->file('image'))->toMediaCollection('main-image');
        return response()->json([
            'status' => true,
            'event' => new EventResource($event)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
            $event = Event::with('category')->find($event->id);
            if (!$event) {
                return response()->json([
                    'status' => false,
                    'message' => 'Event not found'
                ], 404);
            }
            return response()->json([
                'status' => true,
                'event' => new EventResource($event),
            ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
