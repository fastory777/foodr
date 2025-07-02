<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreparationStep extends Model
{
    protected $fillable = [
        'dish_id',
        'step_number',
        'instruction',
        'image_path',
        'duration_minutes',
    ];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
