<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
            'input.*.amount' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
        ];
    }


    public function messages()
    {
        return [
            'input.*.amount.required' => 'Please Enter Amount',
            'input.*.amount.regex' => 'Invalid Amount. Only decimal values are allowed',
        ];
    }
}
