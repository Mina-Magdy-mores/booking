<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Http\Services\EventServices;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public EventServices $eventServices;
    public function __construct()
    {
        $this->eventServices = new EventServices();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $events = $this->eventServices->getEvents($request->per_page);
        if (!$events) {
            return response()->json([
                'status' => false,
                'message' => 'Events not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'events' => EventResource::collection($events)->response()->getData(true)
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
    public function show($id)
    {
        $event = $this->eventServices->getEvent($id);
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
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, $id)
    {
        $validatedData = $request->validated();
        $event = $this->eventServices->getEvent($id);
        if (!$event) {
            return response()->json([
                'status' => false,
                'message' => 'Event not updated'
            ], 500);
        }
        $bool = $event->update($validatedData);
        if (!$bool) {
            return response()->json([
                'status' => false,
                'message' => 'Event not updated'
            ], 500);
        }
        if ($request->hasFile('image')) {
            if ($event->hasMedia('main-image')) {
                $event->clearMediaCollection('main-image');
            }
            $event->addMedia($request->file('image'))->toMediaCollection('main-image');
        }
        return response()->json([
            'status' => true,
            'event' => new EventResource($event->refresh())
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = $this->eventServices->getEvent($id);
        if (!$event) {
            return response()->json([
                'status' => false,
                'message' => 'Event not found'
            ], 404);
        }
       $bool =  $event->delete();
        if (!$bool) {
            return response()->json([
                'status' => false,
                'message' => 'Event not deleted'
            ], 500);
        }
        if ($event->hasMedia('main-image')) {
            $event->clearMediaCollection('main-image');
        }
        return response()->json([
            'status' => true,
            'message' => 'Event deleted successfully'
        ], 200);
    }
}
