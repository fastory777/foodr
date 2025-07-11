<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DishRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $dishId = $this->route('dish')->id ?? null;

        $nameUniqueRule = Rule::unique('dishes', 'name');

        if ((bool) $dishId) {
            $nameUniqueRule->ignore($dishId);
        }

        return [
            'name' => [
                'required',
                'min:3',
                'max:255',
                $nameUniqueRule,
            ],

            'description' => 'required|min:3|max:1024',

            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:10240',
            ],

            'ingredients' => 'required|array|min:1',
            'ingredients.*.id' => 'required|integer|exists:ingredients,id',
            'ingredients.*.amount' => 'required|numeric|min:0.01',
            'ingredients.*.unit' => 'required|string|max:10',

            'preparation_steps' => 'required|array|min:1',
            'preparation_steps.*.instruction' => 'required|string|min:3|max:1024',
            'preparation_steps.*.image' => [
                (bool) $dishId ? 'nullable' : 'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:10240',
            ],
            'preparation_steps.*.duration_minutes' => 'required|integer|min:1',
            'tips' => 'nullable|string|min:3|max:1024',
        ];
    }

    public function attributes(): array
    {
        return [
            'ingredients.*.id' => 'ingredient',
            'ingredients.*.unit' => 'ingredient unit',
            'ingredients.*.amount' => 'ingredient amount',
            'preparation_steps.*.instruction' => 'step instructions',
            'preparation_steps.*.image' => 'step images',
            'preparation_steps.*.duration_minutes' => 'step duration',
        ];
    }
}
