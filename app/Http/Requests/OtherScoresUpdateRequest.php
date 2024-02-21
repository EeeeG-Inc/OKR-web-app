<?php

namespace App\Http\Requests;

use Flash;
use Illuminate\Foundation\Http\FormRequest;

class OtherScoresUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'key_result1_score' => 'nullable|array',
            'key_result2_score' => 'nullable|array',
            'key_result3_score' => 'nullable|array',
            'comment' => 'nullable|array',
            'key_result1_score.*.*' => 'nullable|numeric',
            'key_result2_score.*.*' => 'nullable|numeric',
            'key_result3_score.*.*' => 'nullable|numeric',
            'commen.*' => 'nullable|string',
        ];
    }
}
