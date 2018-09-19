<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'make' => 'required|string|min:3|max:21',
            'model' => 'required|string|min:3|max:21',
            'user_id' => 'required|integer',
        ];
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array $errors
     * @return JsonResponse
     */
    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 200);
        }
    }
}
