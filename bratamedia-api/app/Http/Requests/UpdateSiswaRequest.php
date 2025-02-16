<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;


class UpdateSiswaRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'string|min:3',
            'umur' => 'numeric|min:5',
            'kelasId' => 'numeric|exists:kelas,id'
        ];
    }

    public function prepareForValidation()
    {
        if ($this->filled('keladId')) {
            $this->merge([
                'kelas_id' => $this->kelasId,
            ]);
        }
    }
}
