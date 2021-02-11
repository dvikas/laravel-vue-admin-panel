<?php

namespace App\Transformers\Projects;

use App\Entities\Customer;
use App\Entities\ProjectTask;
use App\Entities\Task;
use League\Fractal\TransformerAbstract;

class CustomerTaskTransformer extends TransformerAbstract
{
    /**
     * @param ProjectTask $model
     * @return array
     */
    public function transform(ProjectTask $model)
    {
        $taskObj = Task::where('id', $model->task_id)->firstOrFail();
        return [
            'id' => $model->uuid,
            'task_id' => $taskObj->uuid,
            'quantity' => $model->quantity,
            'unit' => $model->unit,
            'rate' => $model->rate,
            'total' => $model->total,
            'certificate_path' => $model->certificate_path,
            'milestone_id' => $model->milestone->uuid,
            'parent_id' => $model->task->parentTask->uuid
        ];
    }

}
