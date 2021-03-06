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
            'title' => [
                'min:2', 'max:100',
                Rule::unique('questions')
                    ->ignore(Question::where('title', $request->title)->first()->id),
            ],
            'image' => 'file',
            'description' => '',
            'bonus' => 'integer',
            'time_to_answer' => 'date_format:H:i:s',
            'quiz_id' => 'exists:App\Models\Quiz,id'
        ];
    }
}
