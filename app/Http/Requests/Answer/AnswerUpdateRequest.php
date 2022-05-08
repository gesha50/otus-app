<?php

namespace App\Http\Requests\Answer;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnswerUpdateRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            'title' => 'min:2 | max:100',
            'is_correct' => 'required | boolean',
            'question_id' => 'exists:App\Models\Question,id'
        ];
    }
}
