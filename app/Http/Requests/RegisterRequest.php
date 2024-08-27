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
            'name'=>'required|min:5|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8|max:255',
            'phone_number'=>'required',
        ];
    }

    /**
     * Get the validation error messages that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return [
            'name.required'=>'pls enter your name',
            'name.min'=>'name must be at least 5 characters',
            'name.max'=>'name must be less than 255 characters',
            'email.required'=>'pls enter your email',
            'email.email'=>'pls enter a valid email',
            'email.unique'=>'email already exists',
            'password.required'=>'pls enter your password',
            'password.min'=>'password must be at least 8 characters',
            'password.max'=>'password must be less than 255 characters',
            'phone_number.required'=>'pls enter your phone number',
        ];
    }
}
