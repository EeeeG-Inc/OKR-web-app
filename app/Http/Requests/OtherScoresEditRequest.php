<?php

namespace App\Http\Requests;

use Flash;
use Illuminate\Foundation\Http\FormRequest;

class OtherScoresEditRequest extends FormRequest
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
        ];
    }
}
