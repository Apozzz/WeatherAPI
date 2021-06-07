<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    /**
     * Creates belongsToMany relationship with Weather class Models
     * @return BelongsToMany
     */
    public function weathers(): BelongsToMany
    {
        return $this->belongsToMany(Weather::class);
    }
}

