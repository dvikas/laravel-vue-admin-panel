<?php

namespace App\Transformers\System;

use App\Entities\Supplier;
use League\Fractal\TransformerAbstract;

class SupplierTransformer extends TransformerAbstract
{

    /**
     * @param Supplier $model
     * @return array
     */
    public function transform(Supplier $model)
    {
        return [
            'id' => $model->uuid,
            'name' => $model->name,
            'email' => $model->email,
            'phone' => $model->phone,
            'address' => $model->address,
            'abn' => $model->abn,
            'acn' => $model->acn,
            'tasks' => $model->tasks
        ];
    }
}
