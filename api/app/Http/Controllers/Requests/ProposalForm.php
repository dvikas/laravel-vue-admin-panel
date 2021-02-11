<?php

namespace App\Http\Controllers\Requests;

use App\Thread;
use Illuminate\Foundation\Http\FormRequest;

class ProposalForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
//    public function authorize()
//    {
//        return true;
//    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
//    public function messages()
//    {
//        return [
//            'rate.required' => 'Please enter title.',
//            'total.required'  => 'Please enter body.',
//            'message.required'  => 'Body should be :min char long.',
//        ];
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rate' => 'required',
            'total' => 'required',
            'message' => 'required'
        ];
    }

    public function persist()
    {

//        return Thread::create($this->only(['name', 'email', 'password']));
    }
}
