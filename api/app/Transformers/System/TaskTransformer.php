<?php

namespace App\Transformers\System;

use App\Entities\ParentTask;
use App\Entities\Task;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract
{
    protected $parentId;

    public function __construct($parentTaskId)
    {
        $this->parentId = $parentTaskId; //uuid
    }

    /**
     * @param Task $model
     * @return array
     */
    public function transform(Task $model)
    {
        return [
            'id' => $model->uuid,
            'parent_id' => $this->parentId,
            'name' => $model->name,
            'is_cert_required' => (bool) $model->is_cert_required,
        ];
    }

}
