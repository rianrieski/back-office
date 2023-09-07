<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PegawaiSuamiIstriRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'pegawai_id' => ['required', 'exists:pegawai,id'],
            'nama' => ['required', 'max:100'],
            'nik' => ['required', 'numeric', 'digits:16'],
            'tempat_lahir' => ['required', 'max:50'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d'],
            'tanggal_kawin' => ['required', 'date_format:Y-m-d'],
            'no_kartu' => ['required', 'max:50'],
            'is_pns' => ['required', 'boolean', 'max:1'],
            'pendidikan_id' => ['required', 'exists:pendidikan,id'],
            'pekerjaan' => ['required', 'max:50'],
            'status_tunjangan' => ['required', 'boolean', 'max:1'],
            'no_sk_cerai' => ['nullable', 'max:50'],
            'tmt_sk_cerai' => ['nullable', 'date_format:Y-m-d'],
            'jenis_kawin_id' => ['required', 'exists:jenis_kawin,id'],
            'no_buku_nikah' => ['required', 'max:50'],
            'media_foto_pasangan' => ['nullable', 'mimes:jpg,jpeg,png', 'file', 'max:1024'],
            'media_buku_nikah' => ['nullable', 'mimes:pdf', 'file', 'max:1024']
        ];
    }
    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'pegawai_id.required' => 'pegawai harus diisi',
            'pegawai_id.exists' => 'pegawai tidak valid',
            'pendidikan_id.required' => 'pendidikan harus diisi',
            'pendidikan_id.exists' => 'pendidikan tidak valid',
            'nama.required' => 'nama harus diisi',
            'nama.max' => 'nama maksimal 100 karakter',
            'nik.required' => 'nik harus diisi',
            'nik.numeric' => 'nik harus berupa angka',
            'nik.digits' => 'nik harus 16 digit',
            'tempat_lahir.required' => 'tempat lahir harus diiisi',
            'tempat_lahir.max' => 'tempat lahir maksimal 50 karakter',
            'tanggal_lahir.required' => 'tempat lahir harus diiisi',
            'tanggal_lahir.date_format' => 'tanggal harus dalam bentuk format yang valid',
            'tanggal_kawin.required' => 'tempat kawin harus diiisi',
            'tanggal_kawin.date_format' => 'tanggal harus dalam bentuk format yang valid',
            'no_kartu.required' => 'no kartu harus diiisi',
            'no_kartu.max' => 'no kartu maksimal 50 karakter',
            'is_pns.required' => 'pns harus diiisi',
            'is_pns.boolean' => 'pns tidak valid',
            'status_tunjangan.required' => 'status tunjangan harus diiisi',
            'status_tunjangan.boolean' => 'status tunjangan tidak valid',
            'no_sk_cerai.max' => 'no sk cerai maksimal 50 karakter',
            'tmt_sk_cerai.date_format' => 'tanggal harus dalam bentuk format yang valid',
            'jenis_kawin_id.required' => 'jenis kawin harus diisi',
            'jenis_kawin_id.exists' => 'jenis kawin tidak valid',
            'no_buku_nikah.required' => 'no kartu harus diiisi',
            'no_buku_nikah.max' => 'no kartu maksimal 50 karakter',
            'media_buku_nikah.mimes' => 'format file buku nikah harus pdf',
            'media_buku_nikah.max' => 'ukuran file terlalu besar (maksimal file 1MB)',
            'media_foto_pasangan.mimes' => 'format foto pasangan harus jpg, jpeg, png',
            'media_foto_pasangan.max' => 'ukuran file terlalu besar (maksimal file 1MB)',
        ];
    }
}
