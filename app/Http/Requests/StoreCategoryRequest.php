<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\Temp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Category::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique(Category::class, 'name') ],
            'category_id' => ['nullable', Rule::exists(Category::class, 'id') ],
            'description' => ['required', 'string'],
            'image' => ['nullable', Rule::exists(Temp::class, 'id')]
        ];
    }
}
