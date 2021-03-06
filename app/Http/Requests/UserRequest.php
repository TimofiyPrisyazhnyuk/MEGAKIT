<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:27',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->get('id'),
            'password' => 'required|string|min:6|max:27',
            'confirmation' => 'required_with:password|same:password|min:6|max:27',
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
