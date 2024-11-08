<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreBiayaRequest extends FormRequest
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
            'nama_biaya'    => 'required',
            'jumlah'        => 'required|numeric',
            'parent_id'     => 'nullable|exists:biayas,id'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'jumlah' => Str::replace([' ', '.', 'Rp'], '', $this->jumlah)
        ]);
    }
}
