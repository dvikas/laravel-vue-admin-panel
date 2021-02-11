<?php

namespace App\Transformers\Projects;

use App\Entities\Customer;
use App\Entities\ProjectTask;
use App\Entities\Task;
use League\Fractal\TransformerAbstract;

class MilestoneTransformer extends TransformerAbstract
{
    /**
     * @param ProjectTask $model
     * @return array
     */
    public function transform(ProjectTask $model)
    {
        $taskObj = Task::where('id', $model->task_id )->firstOrFail();
        $custObj = Customer::where('id', $model->customer_id)->firstOrFail();

        return [
            'id' => $model->uuid,
            'task_id' => $taskObj->uuid,
            'customer_id' => $custObj->uuid,
            'label' => $model->quantity,
            'notes' => $model->unit
        ];
    }

}
