<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class QuizStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'link' => ['required', 'unique:quizzes'],
            'image' => 'file',
            'is_visible' => 'boolean | required',
            'category_id' => 'exists:App\Models\Category,id',
            'user_id' => 'exists:App\Models\User,id'
        ];
    }
}
