<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
                    'payment_id' =>'required',
                    'number' => 'required|max:80',
                    'date' => 'required|max:80',
                    'amount' => 'required|max:70',
                    'status' => 'required|max:20'
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'payment_id' =>'required',
                    'number' => 'required|max:80',
                    'date' => 'required|max:80',
                    'amount' => 'required|max:70',
                    'status' => 'required|max:20'
                ];
            default:
                break;
        }
    }
}
