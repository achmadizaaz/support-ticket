<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class HotspotRequest extends FormRequest
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
        $level_role = Auth::user()->roles->max('level');
        return [
            'username' => 'required|string',
            'password' => 'required',
            'nama_lengkap' => $level_role == 1 ? 'required|string' : 'nullable',
            'tempat_lahir' => $level_role == 1 ? 'required|string' : 'nullable',
            'tanggal_lahir' => $level_role == 1 ? 'required|date' : 'nullable',
        ];
    }
}
