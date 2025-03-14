<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class CreateMataPelajaranRequest extends BaseFormRequest
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
            'nama' => 'required|string|min:3',
            'guruId' => 'required|numeric|exists:guru,id'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'guru_id' => $this->guruId
        ]);
    }
}
