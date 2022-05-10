<?php

namespace App\Http\Requests;

use App\Models\{Product, Temp, Type};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Product::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique(Product::class, 'name') ],
            'description' => ['required', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['required',  Rule::exists(Temp::class, 'id')],
            'variants' => ['nullable', 'array'],
            'variants.*.type' => ['required', Rule::exists(Type::class, 'id')],
            'variants.*.name' => ['required', 'string', 'distinct:ignore_case'],
            'variants.*.price' => ['required', 'integer', 'min:1'],
            'variants.*.stock' => ['required', 'integer', 'min:1'],
        ];
    }
}
