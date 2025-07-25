<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DishResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => asset($this->image),
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients')),
            'preparation_steps' => PreparationStepResource::collection($this->whenLoaded('preparationSteps')),
        ];
    }
}
