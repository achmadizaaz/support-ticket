<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'image' => $this->image ? 'mimes:png,jpg,jpeg|max:2048':'',
            'username' => ['required', Rule::unique('users', 'username')->ignore($this->id)],
            'email' => $this->method() == 'POST' ? 'required|email' : '',
            'is_active' => 'required|boolean',
            'password' => $this->method() == 'POST' ? 'required|string|min:5|max:16' :'',
            'homebase' => 'nullable|exists:units,id',
            'role' => 'nullable|exists:roles,id',
            'religion' => 'in:Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu',
            'gender' => 'boolean',
            'date_of_birth' => 'date',
        ];
    }

    public function messages()
    {
        return [
            'is_active.boolean' => 'The is active field must be active or non-active.'
        ];
    }
}
