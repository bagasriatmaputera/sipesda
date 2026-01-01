<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuruRequest extends FormRequest
{
    public function rules(): array
    {
        // Cek apakah input berupa array multidimensi (Bulk)
        if ($this->has('0')) {
            return [
                '*.user_id'  => 'nullable|exists:users,id',
                '*.nip'      => 'required|string|unique:guru,nip',
                '*.nama_guru' => 'required|string|max:255',
                '*.photo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
                '*.kelas_id' => 'nullable|exists:kelas,id',
                '*.no_hp'    => 'nullable|string|max:15|unique:guru,no_hp',
            ];
        }

        if ($this->isMethod('patch')) {
            return [
                'user_id'   => 'nullbale|exists:users,id',
                'nama_guru' => 'nullable|string|max:255',
                'photo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
                'kelas_id'  => 'nullable|exists:kelas,id',
                'no_hp'     => 'nullable|string|max:15|unique:guru,no_hp' > $this->route('guru'),
            ];
        }

        // Aturan untuk input Tunggal (Single)
        return [
            'user_id'   => 'nullbale|exists:users,id',
            'nip'       => 'required|string|unique:guru,nip',
            'nama_guru' => 'required|string|max:255',
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'kelas_id'  => 'nullable|exists:kelas,id',
            'no_hp'     => 'nullable|string|max:15|unique:guru,no_hp',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required'   => 'User ID wajib dihubungkan.',
            'user_id.exists'     => 'Akun user tidak ditemukan.',
            'nip.required'       => 'NIP wajib diisi.',
            'nip.unique'         => 'NIP ini sudah terdaftar di sistem.',
            'nama_guru.required' => 'Nama guru tidak boleh kosong.',
            'kelas_id.exists'    => 'Kelas yang dipilih tidak valid.',
            '*.nip.unique'       => 'Salah satu NIP dalam daftar sudah terdaftar.',
        ];
    }
}
