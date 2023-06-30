<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
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
            'nisn'          => 'required|unique:siswas',
            'jurusan_id'    => 'nullable',
            'kelas'         => 'required',
            'angkatan'      => 'required',
            'foto'          => 'required|image|mimes:jpeg,png,jpg|max:5000'

        ];
    }
}
