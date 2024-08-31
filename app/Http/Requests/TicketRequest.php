<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            'subject' => 'required|string',
            'category' => 'required|numeric',
            'attachment.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:20048',
            'content' => 'required',
            'progress' => 'nullable|numeric|min:0|max:100',
        ];
    }
}