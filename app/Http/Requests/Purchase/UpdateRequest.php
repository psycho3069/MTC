<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'input.*.*' => 'required',
            'input.*.quantity_dr' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
            'input.*.amount' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
        ];
    }


    public function messages()
    {
        return [
            'input.*.*.required' => 'Please Enter Valid Info',
            'input.*.quantity_dr.required' => 'Please Enter Quantity',
            'input.*.quantity_dr.regex' => 'Invalid Quantity. Only decimal values are allowed',
            'input.*.amount.required' => 'Please Enter Amount',
            'input.*.amount.regex' => 'Invalid Amount. Only decimal values are allowed',
        ];
    }
}
