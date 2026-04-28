<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title','description','is_active'])]
class Category extends Model
{
    use HasFactory;
    public function events()
    {
        return $this->hasMany(Event::class);
    }

}
