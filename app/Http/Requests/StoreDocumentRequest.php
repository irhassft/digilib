<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    // Ubah jadi true agar user boleh akses
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:255'],
            'category_id'   => ['required', 'exists:categories,id'], // Pastikan kategori ada
            'description'   => ['nullable', 'string'],
            'document_file' => [
                'required', 
                'file', 
                'mimes:pdf',    // Hanya boleh PDF
                'max:10240'     // Maksimal 10MB (10240 KB)
            ],
        ];
    }
}