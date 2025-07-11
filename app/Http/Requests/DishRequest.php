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
        $isUpdate = $this->isMethod('put');

        $dishId = $this->route('dish')->id ?? $this->route('dish');

        $nameUniqueRule = Rule::unique('dishes', 'name');
        if ($isUpdate) {
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
                $isUpdate ? 'nullable' : 'required',
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
                $isUpdate ? 'nullable' : 'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:10240',
            ],
            'preparation_steps.*.duration_minutes' => 'required|integer|min:1',
            'tips' => 'nullable|string|min:3|max:1024',
        ];
    }
}
