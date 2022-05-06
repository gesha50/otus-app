<?php

namespace App\Http\Requests\Result;

use Illuminate\Foundation\Http\FormRequest;

class ResultStoreRequest extends FormRequest
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
            'user_id' => 'exists:App\Models\User,id',
            'quiz_id' => 'exists:App\Models\Quiz,id',
            'time_to_end' => 'date_format:H:i:s',
            'total_bonus' => 'integer'
        ];
    }
}