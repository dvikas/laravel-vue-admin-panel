<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectTaskProfitsFormRequest extends FormRequest
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
            'quantity' => 'required',
            'unit' => 'required',
            'rate' => 'required',
            'total' => 'required',
        ];
    }

    /**
     * Get the request's data from the request.
     * @return array
     */
    public function getData()
    {
        $data = $this->only([
            'project_task_id', 'rate', 'quantity', 'unit', 'total', 'budgetTotal', 'grandTotal'
        ]);
        return $data;
    }

}
