<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;


class StudentFormRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string:max:255',
            'phone' => [
                'required',
                request()->isMethod('PUT') ? 'unique:students,phone,' . $this->route('student') : 'unique:students,phone',
                'regex:/^0\d{9}$/'
            ],
            'gender' => 'required',
            'birthday' => 'required',
            'address' => 'required|max:255',
            'department_id' => 'required',
            'password' => 'nullable|min:8',
        ];
        if (!request()->isMethod('PUT')) {
            $rules['email'] = 'required|email|unique:users,email';
        }
        return $rules;
    }
}
