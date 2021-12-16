<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObjectiveStoreRequest extends FormRequest
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
            'year' => 'required|integer',
            'quarter' => 'required|integer',
            'key_result1' => 'required|string',
            'key_result2' => 'nullable|string',
            'key_result3' => 'nullable|string',
        ];
    }
}
