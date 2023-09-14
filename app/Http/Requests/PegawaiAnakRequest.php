<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PegawaiAnakRequest extends FormRequest
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
            'pegawai_id'=>['required','exists:pegawai,id'],
            'nama'=>['required','max:50'],
            'nik'=>['required','digits:16'],
            'anak_ke'=>['required','max:2'],
            'tempat_lahir'=>['required','max:50'],
            'tanggal_lahir'=>['required','date_format:Y-m-d'],
            'status_anak'=>['required',Rule::in(["Kandung","Angkat"])],
            'status_tunjangan'=>['required','boolean','max:1'],
            'pendidikan_id'=>['required','exists:pendidikan,id'],
            'bidang_studi'=>['required','max:50'],
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
            'pegawai_id.required'=>'pegawai harus diisi',
            'pegawai_id.exists'=>'pegawai tidak valid',
            'pendidikan_id.required'=>'pendidikan harus diisi',
            'pendidikan_id.exists'=>'pendidikan tidak valid',
            'nama.required'=>'nama harus diisi',
            'nama.max'=>'nama maksimal 50 karakter',
            'nik.required'=>'nik harus diisi',
            'nik.digits'=>'nik harus 16 digit',
            'anak_ke.required'=>'anak ke harus diiisi',
            'anak_ke.max'=>'anak ke maksimal 2 digit',
            'tempat_lahir.required'=>'tempat lahir harus diiisi',
            'tempat_lahir.max'=>'tempat lahir maksimal 50 karakter',
            'tanggal_lahir.required'=>'tempat lahir harus diiisi',
            'tanggal_lahir.date_format'=>'tanggal harus dalam bentuk format yang valid',
            'status_anak.required'=>'status anak harus diiisi',
            'status_anak.in'=>'status anak tidak valid',
            'status_tunjangan.required'=>'status tunjangan harus diiisi',
            'status_tunjangan.boolean'=>'status tunjangan tidak valid',
            'bidang_studi.required'=>'bidang studi harus diiisi',
            'bidang_studi.max'=>'bidang studi maksimal 50 karakter',
        ];
    }
}
