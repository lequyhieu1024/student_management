<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email','max:255', Rule::unique(User::class)],
            'phone' => ['required', Rule::unique('students','phone'), 'regex:/^0\d{9}$/'],
            'gender' => ['required'],
            'birthday' => ['required'],
            'address' => ['required','max:255'],
            'department_id' => ['required'],
            'password' => ['required', 'min:8', 'max:255'],
        ];
    }
}
