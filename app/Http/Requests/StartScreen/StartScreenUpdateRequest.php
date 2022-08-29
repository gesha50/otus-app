<?php

namespace App\Http\Requests\StartScreen;

use App\Models\StartScreen;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StartScreenUpdateRequest extends FormRequest
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
                Rule::unique('start_screens')
                    ->ignore(StartScreen::where('title', $request->title)->first()->id)
            ],
            'image' => 'nullable | file',
            'description' => '',
            'source' => '',
            'quiz_id' => 'exists:App\Models\Quiz,id'
        ];
    }
}
