<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'dish_id' => $this->dish_id,
            'user_id' => $this->user_id,
            'author_name' => $this->author_name,
            'content' => $this->content,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
