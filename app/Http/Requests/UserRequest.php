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
            'image' => $this->image ? 'mimes:png,jpg|max:2048':'',
            'username' => 'required',
            'email' => 'required|email',
            'is_active' => 'required|boolean',
            'password' => 'required|min:5',
            'role' => 'required',
        ];
    }
}
