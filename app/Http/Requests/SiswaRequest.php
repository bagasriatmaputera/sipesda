<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Kondisi jika input berupa array (Bulk)
        if ($this->has('0')) {
            return [
                '*.nis' => ['required', 'numeric', 'digits:10', 'unique:siswa,nis,' . $this->route('siswa')],
                '*.photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
                '*.nama' => ['required', 'string', 'max:150'],
                '*.kelas_id' => ['required', 'integer', 'exists:kelas,id'], // Sesuaikan exists ke tabel kelas
                '*.nama_wali' => ['required', 'string', 'max:150'],
                '*.no_hp_wali' => ['required', 'string', 'min:11', 'unique:siswa,no_hp_wali,' . $this->route('siswa')],
            ];
        }

        // Kondisi input tunggal
        return [
            'nis' => ['required', 'numeric', 'digits:10', 'unique:siswa,nis,' . $this->route('siswa')],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
            'nama' => ['required', 'string', 'max:150'],
            'kelas_id' => ['required', 'integer', 'exists:kelas,id'],
            'nama_wali' => ['required', 'string', 'max:150'],
            'no_hp_wali' => ['required', 'string', 'min:11', 'unique:siswa,no_hp_wali,' . $this->route('siswa')],
        ];
    }

    public function messages(): array
    {
        return [
            // Pesan untuk input Tunggal
            'nis.required' => 'Nomor Induk Siswa (NIS) wajib diisi.',
            'nis.unique' => 'NIS ini sudah terdaftar.',
            'no_hp_wali.unique' => 'Nomor HP Wali ini sudah terdaftar.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak ditemukan.',

            // Pesan untuk input Bulk (menggunakan asterisk)
            '*.nis.required' => 'NIS pada salah satu data wajib diisi.',
            '*.nis.unique' => 'Salah satu NIS sudah terdaftar di sistem.',
            '*.no_hp_wali.min_digits' => 'Nomor HP Wali minimal 11 digit.',
            '*.nama.required' => 'Nama siswa wajib diisi.',
        ];
    }
}
