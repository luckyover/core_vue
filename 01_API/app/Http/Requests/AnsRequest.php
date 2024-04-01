<?php

namespace App\Http\Requests;

use AnsResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use ResponseCode;

abstract class AnsRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errorCode = array_values((new ValidationException($validator))->errors())[0];
        $response = new AnsResponse;
        $response->code = ResponseCode::BAD_REQUEST;
        $response->messageNo = $errorCode[0];
        $response->invalidData = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json($response, ResponseCode::BAD_REQUEST));
    }

    public function messages()
    {
        return [
            'required' => 'E001',
        ];
    }

    public function setDefaultValues($dataDefaults, $data)
    {
        foreach ($dataDefaults as $key => $value) {
            if (!isset($data[$key]) || $data[$key] == null) {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance();
    }
}
