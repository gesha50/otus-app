<?php

namespace App\Http\Requests\Question;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QuestionUpdateRequest extends FormRequest
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
            'title' => 'max:100',
            'image' => 'file',
            'description' => '',
            'bonus' => 'integer',
            'correct_answer' => 'integer',
            'time_to_answer' => 'date_format:H:i:s',
            'full_answer_image' => 'max:256',
            'full_answer' => 'max:256',
            'quiz_id' => 'exists:App\Models\Quiz,id'
        ];
    }
}
