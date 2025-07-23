<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvaluasiKinerjaRequest extends FormRequest
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
            'nama_evaluasi' => 'required|string',
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'nama_evaluasi.required' => 'Nama evaluasi harus diisi.',
            'bulan.required' => 'Bulan harus diisi.',
            'tahun.required' => 'Tahun harus diisi.',
        ];
    }
}
