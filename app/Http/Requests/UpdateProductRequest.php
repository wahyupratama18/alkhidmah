<?php

namespace App\Http\Requests;

use App\Models\{Picture, Product, Temp};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->product);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique(Product::class, 'name')->ignore($this->product) ],
            'description' => ['required', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['required',  Rule::exists(Temp::class, 'id')],
            'deleted' => ['nullable', 'array'],
            'deleted.*' => ['required', Rule::exists(Picture::class)]
        ];
    }
}
