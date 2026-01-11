<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JenisPelanggaranRequest extends FormRequest
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
        if ($this->has('0')) {
            return [
                '*.nama_pelanggaran' => 'required|string|min:5',
                '*.tingkat_pelanggaran_id' => 'required|string|min:5',
                '*.poin' => 'required|numeric|min:1'
            ];
        }

        if ($this->isMethod('patch')) {
            return [
                'nama_pelanggaran' => 'required|string|min:5',
                'tingkat_pelanggaran_id' => 'nullable|string|min:5',
                'poin' => 'nullable|numeric|min:1'
            ];
        }
        return [
            'nama_pelanggaran' => 'required|string|min:5',
            'tingkat_pelanggaran_id' => 'required|string|min:5',
            'poin' => 'required|numeric|min:1'
        ];
    }
}
