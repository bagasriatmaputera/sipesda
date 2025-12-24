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
                'exists:jenis_pelanggarans,id', // Pastikan ID kategori pelanggaran valid
            ],
            'tanggal' => [
                'required',
                'date',
                'before_or_equal:today', // Tanggal tidak boleh di masa depan
            ],
            'poin' => [
                'required',
                'integer',
                'min:1', // Poin minimal biasanya 1
            ],
            'keterangan' => [
                'nullable', // Boleh kosong
                'string',
                'max:255',
            ],
        ];
    }
}
