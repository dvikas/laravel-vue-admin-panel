<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuppliersFormRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ];
    }

    /**
     * Get the request's data from the request.
     * @return array
     */
    public function getData()
    {
        $data = $this->only(
            ['name',
            'email',
            'phone',
            'address',
            'abn',
            'acn'
            ]
        );
        return $data;
    }

}
