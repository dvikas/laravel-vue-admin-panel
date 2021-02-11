<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerTasksFormRequest extends FormRequest
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
            'project_id' => 'required',
            'parent_task' => 'required',
            'parent_task_id' => 'required',
            'child_task' => 'required',
            'child_task_id' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'rate' => 'required',
            'total' => 'required',
            'parent_position' => 'required',
            'child_position' => 'required',
        ];
    }

    /**
     * Get the request's data from the request.
     * @return array
     */
    public function getData()
    {
        $data = $this->only(
            ['project_id',
            'parent_task',
            'parent_task_id',
            'child_task',
            'child_task_id',
            'parent_position',
            'child_position',
            'quantity',
            'unit',
            'rate',
            'total',
            'certificate_path',
            'is_cert_required',
            'isVariation'
            ]
        );

        return $data;

    }

}
