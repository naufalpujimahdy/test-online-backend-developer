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
            'email'    => 'required|email|unique:users',
            'name'     => 'required|string',
            'password' => 'required|string|min:6',
            'username' => 'required|string|unique:users',
        ];
    }

    public function messages()
    {
        return [
            'email.required'    => 'Email is required',
            'email.email'       => 'Email is not valid',
            'email.unique'      => 'Email is already taken',
            'name.required'     => 'Name is required',
            'name.string'       => 'Name must be a string',
            'password.required' => 'Password is required',
            'password.string'   => 'Password must be a string',
            'password.min'      => 'Password must be at least 6 characters',
            'username.required' => 'Username is required',
            'username.string'   => 'Username must be a string',
            'username.unique'   => 'Username is already taken',
        ];
    }
}
