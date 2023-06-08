<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OkrGetOursRequest extends FormRequest
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
            'year' => 'nullable|integer',
            'quarter_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'is_archived' => 'nullable|integer',
            'is_include_full_year' => 'nullable|integer',
        ];
    }
}
