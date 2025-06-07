<?php

namespace App\Base;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    function failedValidation(Validator $validator) { 
        $errors         = $validator->errors();
        $_msg_errors    = $errors->getMessages();
        $_messages = null;
        if(is_array($_msg_errors)){
            foreach($_msg_errors as $key => $e){
                $_messages['errors'][$key] = $e;
            }
        }
        $response = [
            'success' => false,
            'errors' => $errors->getMessages(),
            'data' => $_messages,
            'code' => 422
        ];
        throw new HttpResponseException(
        response()->json($response, 422));
    }
}
