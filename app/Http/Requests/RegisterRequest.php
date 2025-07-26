<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|max:255',
            'phone_number' => 'required|digits:15',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must not exceed 255 characters',

            'email.unique' => 'Email has already been taken',
            'email.max' => 'Email must not exceed 255 characters',
            'email' => 'Email must be a valid email address',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',

            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password must not exceed 255 characters',
            
            'phone_number.required' => 'Phone number is required',
            'phone_number.digits' => 'Phone number must be exactly 15 digits',
           
        ];
    }
}
