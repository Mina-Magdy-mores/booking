<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable(['title', 'description', 'location', 'start_date', 'ended_date', 'price', 'available_seats', 'is_active', 'category_id'])]
class Event extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;
    protected $casts = [
        'start_date' => 'datetime',
        'ended_date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
