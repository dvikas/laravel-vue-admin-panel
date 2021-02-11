<?php

namespace App\Transformers\System;

use App\Entities\ParentTask;
use League\Fractal\TransformerAbstract;

class ParentTaskTransformer extends TransformerAbstract
{
    /**
     * @param ParentTask $model
     * @return array
     */
    public function transform(ParentTask $model)
    {
        return [
            'id' => $model->uuid,
            'name' => $model->name
        ];
    }

}
