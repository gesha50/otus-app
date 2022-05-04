<?php

namespace App\Http\Requests\Quiz;

use App\Models\Quiz;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QuizUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     * @return array
     */
    public function rules(Request $request): array
    {
        return [
            'link' => Rule::unique('quizzes')->ignore(Quiz::where('link', $request->link)->first()->id),
            'image' => 'file',
            'is_visible' => 'boolean | required',
            'category_id' => 'exists:App\Models\Category,id',
            'user_id' => 'exists:App\Models\User,id'
        ];
    }
}
