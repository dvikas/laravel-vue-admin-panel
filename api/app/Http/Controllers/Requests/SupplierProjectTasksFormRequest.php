<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierProjectTasksFormRequest extends FormRequest
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
            'supplier_user_task_id' => 'required',
            'project_id' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'deadline' => 'required',
        ];
    }

    /**
     * Get the request's data from the request.
     * @return array
     */
    public function getData()
    {
        $data = $this->only([
            'supplier_user_task_id','project_id','quantity','unit','deadline'
        ]);
        return $data;
    }

}
