<?php

namespace App\Http\Requests;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

class UpdateSiswaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama'          => 'required',
            'wali_id'       => 'nullable',
            'biaya_id'      => 'required|exists:biayas,id',
            'nisn'          => 'required|unique:siswas,nisn,' . $this->siswa,
            'jurusan_id'    => 'nullable',
            'kelas'         => 'required',
            'angkatan'      => 'required'
        ];
    }
}
