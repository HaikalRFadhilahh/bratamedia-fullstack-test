<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseFormRequest extends FormRequest
{
    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            'statusCode' => 403,
            'status' => "error",
            "message" => "Forbidden"
        ], 403));
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'statusCode' => 400,
            'status' => "error",
            "message" => $validator->errors()
        ], 400));
    }
}
