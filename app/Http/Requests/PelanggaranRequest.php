<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PelanggaranRequest extends FormRequest
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
        // Cek apakah input berupa array multidimensi (Bulk)
        if ($this->has('0')) {
            return [
                '*' => 'required|array',
                '*.siswa_id' => 'required|exists:siswa,id',
                '*.guru_id' => 'required|exists:users,id',
                '*.jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
                '*.keterangan' => [
                    'nullable', // Boleh kosong
                    'string',
                    'max:255',
                ],
            ];
        }

        return [
            'siswa_id' => [
                'required',
                'integer',
                'exists:siswa,id', // Pastikan ID siswa ada di tabel siswa
            ],
            'guru_id' => [
                'required',
                'integer',
                'exists:guru,id', // Pastikan ID guru ada di tabel gurus
            ],
            'jenis_pelanggaran_id' => [
                'required',
                'integer',
                'exists:jenis_pelanggaran,id', // Pastikan ID kategori pelanggaran valid
            ],
            // 'tanggal' => [
            //     'required',
            //     'date',
            //     'before_or_equal:today', // Tanggal tidak boleh di masa depan
            // ],
            // 'poin' => [
            //     'required',
            //     'integer',
            //     'min:1', // Poin minimal biasanya 1
            // ],
            'keterangan' => [
                'nullable', // Boleh kosong
                'string',
                'max:255',
            ],
        ];
    }
}
