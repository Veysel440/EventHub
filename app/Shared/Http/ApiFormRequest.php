<?php

namespace App\Shared\Http;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Shared\Exceptions\ApiException;

abstract class ApiFormRequest extends FormRequest
{
    protected function failedAuthorization() { throw new ApiException('forbidden', 403); }
    protected function failedValidation(Validator $v) { throw new ApiException('validation_error', 422, $v->errors()); }
}
