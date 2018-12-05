<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'email' => 'required|string|email',
            'phone' => 'nullable|regex:/^[0-9-_+)(\s]{7,30}$/',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|max:255',
            'confirm_password' => 'nullable|string|confirmed:password'
        ];
    }
}
