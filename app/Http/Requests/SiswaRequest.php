<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiswaRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan untuk membuat request ini.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // NIS (Nomor Induk Siswa)
            'nis' => [
                'required',             // Wajib diisi
                'numeric',              // Harus berupa angka
                'digits:10',            // Harus 10 digit
                'unique:siswa,nis',    // Harus unik di tabel 'siswa'
            ],

            // Nama Siswa
            'nama' => [
                'required',             // Wajib diisi
                'string',               // Harus berupa string
                'max:150',              // Panjang maksimal 150 karakter
            ],

            // Kelas Siswa
            'kelas' => [
                'required',             // Wajib diisi
                'string',               // Harus berupa string
                'in:10A,10B,11A,11B,12A,12B', // Hanya nilai-nilai ini yang diizinkan
            ],

            // Total Poin
            'total_poin' => [
                'required',             // Wajib diisi
                'integer',              // Harus berupa bilangan bulat
                'min:0',                // Nilai minimal 0
            ],
        ];
    }

    /**
     * Dapatkan custom pesan error untuk aturan validasi yang didefinisikan.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nis.required' => 'Nomor Induk Siswa (NIS) wajib diisi.',
            'nis.numeric' => 'NIS harus berupa angka.',
            'nis.digits' => 'NIS harus terdiri dari 10 digit.',
            'nis.unique' => 'NIS ini sudah terdaftar.',

            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 150 karakter.',

            'kelas.required' => 'Kelas wajib diisi.',
            'kelas.in' => 'Kelas tidak valid. Pilih dari daftar kelas yang tersedia.',

            'total_poin.required' => 'Total poin wajib diisi.',
            'total_poin.integer' => 'Total poin harus berupa bilangan bulat.',
            'total_poin.min' => 'Total poin minimal adalah 0.',
        ];
    }
}
