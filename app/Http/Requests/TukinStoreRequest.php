<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TukinStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'grade' => ['required', 'integer', 'min:1', 'max:9999'],
            'nominal' => ['required', 'integer', 'min:1', 'max:999999999999999'],
            'keterangan' => [],
        ];
    }
}
