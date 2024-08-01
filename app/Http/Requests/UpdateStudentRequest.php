<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;


class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', Rule::unique('users', 'email')->ignore($this->user)],
            'phone' => ['required', Rule::unique('students','phone')->ignore($this->student), 'regex:/^0\d{9}$/'],
            'gender' => ['required'],
            'birthday' => ['required'],
            'address' => ['required'],
            'department_id' => ['required'],
            'password' => ['min:8'],
        ];
    }
}
