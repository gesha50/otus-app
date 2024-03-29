<?php

namespace App\Http\Requests\ResultDetail;

use Illuminate\Foundation\Http\FormRequest;

class ResultDetailStoreRequest extends FormRequest
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
            'result_id' => 'exists:App\Models\Result,id',
            'question_id' => 'exists:App\Models\Question,id',
            'choice' => 'integer | nullable',
            'time_to_end' => 'date_format:"H:i:s"',
        ];
    }
}
