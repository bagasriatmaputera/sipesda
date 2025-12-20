<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrangTuaRequest extends FormRequest
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
            'siswa_id' => 'required|exist:siswa,id',
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|min:11|unique:orang_tua,no_wa'
        ];
    }
}
