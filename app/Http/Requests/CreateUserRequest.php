<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^[0-9]{10}$/',
            'description' => 'required|string',
            'roleId' => 'required|exists:roles,id',
            'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'phone.required' => 'The phone field is required.',
            'phone.regex' => 'The phone must be a valid 10-digit phone number.',
            'description.required' => 'The description field is required.',
            'roleId.required' => 'The role ID field is required.',
            'roleId.exists' => 'The selected role ID is does not exists in database.',
            'profileImage.required' => 'The profile image field is required.',
            'profileImage.image' => 'The profile image must be an image.',
            'profileImage.mimes' => 'The profile image must be a file of type: jpeg, png, jpg, gif.',
            'profileImage.max' => 'The profile image may not be greater than 2048 kilobytes.',
        ];
    }
}
