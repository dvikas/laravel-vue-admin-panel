<?php

namespace App\Transformers\Users;

use App\Entities\DraftTask;
use League\Fractal\TransformerAbstract;

class DraftTasksTransformer extends TransformerAbstract
{
    public function transform(DraftTask $model)
    {
        return [
            'id' => $model->uuid,
            'name' => $model->name
        ];
    }

}
