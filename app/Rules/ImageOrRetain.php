<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class ImageOrRetain implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Case 1: check if valid image
        if (is_a($value, UploadedFile::class)) {
            if (! $value->isValid() || $value->getSize() > 10 * 2048 * 2048) {
                $fail('The :attribute must be an image and less than 10MB.');

                return;
            }

            $mimes = $value->getMimeType();
            if (! in_array($mimes, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'])) {
                $fail('The :attribute must be a valid image format (jpeg, png, gif, svg).');
            }

            return;
        }

        // Case 2: previously saved image path (already in storage)
        if (is_string($value) && str_starts_with($value, 'storage/')) {
            return;
        }

        // Case 3: anything else is invalid
        $fail('The image must be an image or remain unchanged.');

    }
}
