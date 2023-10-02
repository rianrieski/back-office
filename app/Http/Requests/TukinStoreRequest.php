<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TukinStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'grade' => ['required', 'integer', 'min:1', 'max:50',
                Rule::unique('tukin', 'grade')->ignore(request('tukin'))
            ],
            'nominal' => ['required', 'integer', 'min:1', 'max:999999999999999'],
            'keterangan' => [],
        ];
    }
}
