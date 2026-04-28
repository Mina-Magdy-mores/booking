<?php

namespace App\Http\Services;

use App\Http\Resources\EventResource;
use App\Models\Event;

class EventServices
{
    public function getEvents($per_page)
    {
        return Event::with('category')->paginate($per_page ?? 5);
    }
    public function getEvent($id)
    {
        return Event::with('category')->find($id);
    }
    public function create($validatedData)
    {
        return  Event::create($validatedData);
    }
    public function update($event, $validatedData)
    {

        return $event->update($validatedData);
    }
    public function delete($event)
    {
        return $event->delete();
    }
}
