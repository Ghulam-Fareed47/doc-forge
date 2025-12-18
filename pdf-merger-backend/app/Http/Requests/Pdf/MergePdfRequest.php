<?php

namespace App\Http\Requests\Pdf;

use Illuminate\Foundation\Http\FormRequest;

class MergePdfRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'files' => 'required|array|min:2',
            'files.*' => 'required|file|mimes:pdf|max:10240', // 10MB max per file
        ];
    }
}
