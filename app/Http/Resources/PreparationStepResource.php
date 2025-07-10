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
            'image_path' => storage_path($this->image_path),
            'duration_minutes' => $this->duration_minutes,
        ];
    }
}
