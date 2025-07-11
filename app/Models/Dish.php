<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dish extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    /**
     * The ingredients used in this dish.
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('amount', 'unit');
    }

    /**
     * The meals that use this dish.
     */
    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }

    public function preparationSteps()
    {
        return $this->hasMany(PreparationStep::class);
    }

    public function getImageUrlAttribute($value)
    {
        return asset('storage/'.$value);
    }

    public function tips()
    {
        return $this->hasMany(Tip::class);
    }
}
