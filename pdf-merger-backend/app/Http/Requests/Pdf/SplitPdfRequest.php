<?php

namespace App\Http\Requests\Pdf;

use Illuminate\Foundation\Http\FormRequest;

class SplitPdfRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pdf' => 'required|file|mimes:pdf|max:20480', // 20MB max
            'pages' => ['required', 'string', 'regex:/^(\d+(-\d+)?)(,\d+(-\d+)?)*$/'], // e.g. "1,3,5-7"
        ];
    }
}
