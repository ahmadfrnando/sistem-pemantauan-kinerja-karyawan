<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManajemenTugasRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_tugas' => 'required|string',
            'karyawan_id' => 'required|exists:karyawan,id',
            'deskripsi' => 'nullable|string',
            'file_tugas' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nama_tugas.required' => 'Nama tugas harus diisi.',
            'karyawan_id.required' => 'Karyawan harus diisi.',
            'file_tugas.mimes' => 'File harus berupa PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG.',
            'file_tugas.max' => 'Ukuran file maksimal 2MB.',
        ];
    }
}
