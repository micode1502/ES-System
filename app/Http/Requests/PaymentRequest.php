<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
                    'patient_id' =>'required',
                    'city' => 'required|string|max:80',
                    'state' => 'required|string|max:80',
                    'postal_code' => 'required|max:70',
                    'payment_method' => 'required|string|max:20',
                    'amount' => 'required|min:1'
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'patient_id' =>'required',
                    'city' => 'required|string|max:80',
                    'state' => 'required|string|max:80',
                    'postal_code' => 'required|max:70',
                    'payment_method' => 'required|string|max:20',
                    'amount' => 'required|min:1'
                ];
            default:
                break;
        }
    }
}
