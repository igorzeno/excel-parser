<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExcelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required|mimes:csv,xlsx,xls',
        ];
    }
}
