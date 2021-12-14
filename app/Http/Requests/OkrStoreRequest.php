<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OkrStoreRequest extends FormRequest
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
            'okr' => 'required|string',
            'year' => 'required|integer',
            'quarter' => 'required|integer',
            'objective1' => 'required|string',
            'objective2' => 'nullable|string',
            'objective3' => 'nullable|string',
        ];
    }
}
