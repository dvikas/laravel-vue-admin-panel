<?php

namespace App\Transformers\Projects;

use App\Entities\SupplierProjectTask;
use League\Fractal\TransformerAbstract;

class SupplierProjectTaskTransformer extends TransformerAbstract
{

    /**
     * @param SupplierProjectTask $model
     * @return array
     */
    public function transform(SupplierProjectTask $model)
    {
        return [
            'id' => $model->uuid,
            'quantity' => $model->quantity,
            'unit' => $model->unit,
            'deadline' => $model->deadline,
            'supplierUserTask' => $model->supplierUserTask,
            'supplierQuoteDetails' => $model->supplierQuoteDetails
        ];
    }
}