<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dish_id' => 'nullable|exists:dishes,id',
            'content' => 'required|string|max:1000',
            'author_name' => $this->user()
                ? 'nullable|string|max:255'
                : 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Please enter a comment.',
            'author_name.required' => 'Please enter your name.',
        ];
    }

    public function prepareForValidation(): void
    {
        if ($this->user()) {
            $this->merge([
                'author_name' => $this->user()->name,
            ]);
        }
    }
}
