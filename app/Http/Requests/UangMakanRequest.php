<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UangMakanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'golongan_id' => ['required', 'exists:golongan,id',
                Rule::unique('uang_makan', 'golongan_id')->ignore(request('umak'))
            ],
            'nominal' => ['required', 'integer', 'min:1', 'max:9999999999'],
        ];
    }
}
