<?php

namespace App\Http\Requests\StartScreen;

use Illuminate\Foundation\Http\FormRequest;

class StartScreenStoreRequest extends FormRequest
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
            'title' => ['required', 'min:2', 'max:100', 'unique:start_screens'],
            'image' => 'file',
            'description' => '',
            'source' => '',
            'quiz_id' => 'exists:App\Models\Quiz,id'
        ];
    }
}
