<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'mis_head_id' => 'required|in:4,5',
            'input.*.*' => 'required',
            'input.*.quantity_dr' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
            'input.*.amount' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
        ];
    }



    public function messages()
    {
        return [
            'mis_head_id.required' => 'Your request can\'t be completed. Please try again',
            'input.*.*.required' => 'Please Enter Valid Info',
            'input.*.quantity_dr.required' => 'Please Enter Quantity',
            'input.*.quantity_dr.regex' => 'Invalid Quantity. Only decimal values are allowed',
            'input.*.amount.required' => 'Please Enter Amount',
            'input.*.amount.regex' => 'Invalid Amount. Only decimal values are allowed',
        ];
    }


}
