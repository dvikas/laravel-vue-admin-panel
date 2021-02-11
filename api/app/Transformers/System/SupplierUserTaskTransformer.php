<?php

namespace App\Transformers\System;

use App\Entities\SupplierUserTask;
use League\Fractal\TransformerAbstract;

class SupplierUserTaskTransformer extends TransformerAbstract
{

    /**
     * @param SupplierUserTask $model
     * @return array
     */
    public function transform(SupplierUserTask $model)
    {
        return [
            'id' => $model->uuid,
            'name' => $model->name,
            'suppliers' => $model->suppliers
        ];
    }
}
