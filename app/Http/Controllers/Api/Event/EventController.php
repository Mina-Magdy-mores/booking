<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Http\Services\EventServices;
use App\Http\Services\MediaService;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public EventServices $eventServices;
    protected MediaService $mediaService;
    public function __construct(MediaService $mediaService, EventServices $eventServices)
    {
        $this->eventServices = $eventServices;
        $this->mediaService = $mediaService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $events = $this->eventServices->getEvents($request->per_page);
        $events->each(function ($event) {
            $event->image = $this->mediaService->getMedia($event, 'event-image');
        });
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
        $images = $request->file('image');
        foreach ($images as $image) {
            $this->mediaService->createMedia($event, $image, 'event-image');
        }
        $event->image = $this->mediaService->getMedia($event, 'event-image');
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
        $event->image = $this->mediaService->getMedia($event, 'event-image');
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
    public function update(UpdateEventRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $event = $this->eventServices->getEvent($id);
        if (!$event) {
            return response()->json([
                'status' => false,
                'message' => 'Event not updated'
            ], 500);
        }
        $bool = $this->eventServices->update($event, $validatedData);
        if (!$bool) {
            return response()->json([
                'status' => false,
                'message' => 'Event not updated'
            ], 500);
        }
        if ($request->hasFile('image')) {
            $this->mediaService->deleteMedia($event, 'event-image');
            $images = $request->file('image');
            foreach ($images as $image) {
                $this->mediaService->createMedia($event, $image, 'event-image');
            }
            $event->refresh()->image = $this->mediaService->getMedia($event, 'event-image');
        }
        return response()->json([
            'status' => true,
            'event' => new EventResource($event),
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
        $bool = $this->eventServices->delete($event);
        if (!$bool) {
            return response()->json([
                'status' => false,
                'message' => 'Event not deleted'
            ], 500);
        }
        $this->mediaService->deleteMedia($event, 'event-image');
        return response()->json([
            'status' => true,
            'message' => 'Event deleted successfully'
        ], 200);
    }
}
