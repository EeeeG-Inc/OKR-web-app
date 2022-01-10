<?php

namespace App\Http\Requests;

use Flash;
use Illuminate\Foundation\Http\FormRequest;

class ObjectiveUpdateRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'objective' => 'required|string',
            'objective_remarks' => 'nullable|string',
            'year' => 'required|integer',
            'quarter_id' => 'required|integer',
            'key_result1' => 'required|string',
            'key_result1_id' => 'required|integer',
            'key_result1_score' => 'nullable|numeric',
            'key_result1_remarks' => 'nullable|string',
            'key_result2' => 'nullable|string',
            'key_result2_id' => 'nullable|integer',
            'key_result2_score' => 'nullable|numeric',
            'key_result2_remarks' => 'nullable|string',
            'key_result3' => 'nullable|string',
            'key_result3_id' => 'nullable|integer',
            'key_result3_score' => 'nullable|numeric',
            'key_result3_remarks' => 'nullable|string',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $messages = $validator->errors()->getMessages();

            foreach ($messages as $message) {
                Flash::error($message[0]);
            }
        });
    }
}
