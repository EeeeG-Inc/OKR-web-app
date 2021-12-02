<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OkrCreateRequest extends FormRequest
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
            'inputOkr' => 'required|string',
            'inputObjective1' => 'required|string',
            'inputObjective2' => 'nullable|string',
            'inputObjective3' => 'nullable|string',
        ];
    }
}
