<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitKerjaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'integer'],
            'jenis_unit_kerja_id' => ['required', 'integer'],
            'is_active' => ['nullable', 'boolean'],
            'nama' => ['required'],
            'singkatan' => ['nullable'],
            'keterangan' => ['nullable'],
        ];
    }
}
