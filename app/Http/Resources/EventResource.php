<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'start_date' => $this->start_date->diffForHumans(),
            'ended_date' => $this->ended_date->diffForHumans(),
            'price' => $this->price,
            'available_seats' => $this->available_seats,
            'is_active' => $this->is_active,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'image' => $this->getMedia('main-image')->map(function ($item) {
                return [
                    'id' => $item->id,
                    'url' => $item->getUrl(),
                ];
            }),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans()
        ];
    }
}
