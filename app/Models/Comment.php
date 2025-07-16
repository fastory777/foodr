<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'dish_id',
        'user_id',
        'author_name',
        'content',
    ];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
