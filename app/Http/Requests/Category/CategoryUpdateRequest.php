<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'title' => [
                'required', 'max:100', 'min:2',
                Rule::unique('categories')->ignore(Category::where('title', $request->title)->first()->id),
            ],
            'image' => 'file'
        ];
    }
}
