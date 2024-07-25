<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string|max:80',
                    'lastname' => 'required|string|max:180',
                    'email' => 'required|unique:users|max:70',
                    'password' => 'required|min:8'
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => 'required|string|max:80',
                    'lastname' => 'required|string|max:180',
                    'email' => 'required|unique:users,email,'.$this->get('id').'|max:70',
                    'password' => 'min:0'
                ];
            default:
                break;
        }
    }
}
