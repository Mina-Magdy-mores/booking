<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title','is_active'])]
class Category extends Model
{
    public function events()
    {
        return $this->hasMany(Event::class);
    }

}
