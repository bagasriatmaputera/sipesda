<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Logika validasi untuk single atau bulk
        $rules = [
            'nama_kelas' => 'required|string|max:50',
            'wali_kelas' => 'nullable|string|max:100',
        ];

        if ($this->has('0')) {
            return [
                '*.nama_kelas' => 'required|string|max:50',
                '*.wali_kelas' => 'nullable|string|max:100',
            ];
        }

        return $rules;
    }
}
