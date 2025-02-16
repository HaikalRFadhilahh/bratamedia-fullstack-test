<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateGuruKelasRequest extends BaseFormRequest
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
            'guruId' => 'required|numeric|exists:guru,id',
            'kelasId' => 'required|numeric|exists:kelas,id'
        ];
    }

    public function prepareForValidation()
    {
        if ($this->filled('guruId')) {
            $this->merge([
                'guru_id' => $this->guruId
            ]);
        }

        if ($this->filled('kelasId')) {
            $this->merge([
                'kelas_id' => $this->kelasId
            ]);
        }
    }
}
