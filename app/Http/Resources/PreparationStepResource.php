<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PreparationStepResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'step_number' => $this->step_number,
            'instruction' => $this->instruction,
            'image_path' => $this->image_path ? asset($this->image_path) : null, // // converts a stored image path to a full public url. This ensures that the frontend receives a usable link
            'duration_minutes' => $this->duration_minutes,
        ];
    }
}
