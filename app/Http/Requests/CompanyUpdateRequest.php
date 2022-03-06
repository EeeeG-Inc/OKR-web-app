<?php

namespace App\Http\Requests;

use Flash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CompanyUpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'role' => 'required|integer',
            'department_id' => 'nullable|integer',
            'profile_image'=>'nullable|image|mimes:jpeg,png,jpg',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . Auth::user()->id,
            'password' => 'nullable|string|min:8|confirmed|passwordFormat',
            'password_confirmation' => 'nullable|string|min:8',
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
