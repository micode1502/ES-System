<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailabilityRequest extends FormRequest
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
                    'doctor_id' =>'required',
                    'day' => 'required|integer|between:0,6',
                    'hour_start' => 'required',
                    'duration' => 'required|integer|min:1'
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'doctor_id' =>'required',
                    'day' => 'required|integer|between:0,6',
                    'hour_start' => 'required',
                    'duration' => 'required|integer|min:1'
                ];
            default:
                break;
        }
    }
}
