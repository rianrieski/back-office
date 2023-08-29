<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TukinStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'grade' => ['required', 'numeric'],
            'nominal' => ['required', 'numeric'],
        ];
    }
}
