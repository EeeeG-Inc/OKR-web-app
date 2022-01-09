<?php

namespace App\Http\Requests;

use Flash;
use Illuminate\Foundation\Http\FormRequest;

class QuarterUpdateRequest extends FormRequest
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
            '1q_from' => 'required|integer',
            '1q_to' => 'required|integer',
            '2q_from' => 'required|integer',
            '2q_to' => 'required|integer',
            '3q_from' => 'required|integer',
            '3q_to' => 'required|integer',
            '4q_from' => 'required|integer',
            '4q_to' => 'required|integer',
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
