<?php

namespace App\Entities;

use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Model;


class DraftTask extends Model
{
    use UuidScopeTrait;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    public static function setDraftTasksSubTasks($draftId, $projectId){

        ProjectMilestone::deleteProjectTaskSubtasks($projectId);

        $draftTasks = DraftProjectMilestone::where('draft_task_id',$draftId)
            ->with('draftCustomerTasks')->get()->toArray();

        foreach($draftTasks as $key=>$task){
            $mileStoneObj = ProjectMilestone::create([
                'task_id' => $task['task_id'],
                'position' => $task['position'],
//                'customer_id' => $customerId,
                'project_id' => $projectId,
                'user_id' => auth()->id()
            ]);


            foreach($task['draft_customer_tasks'] as $customerTask) {

                ProjectTask::create([
                    'task_id' => $customerTask['task_id'],
                    'milestone_id' => $mileStoneObj->id,
                    'position' => $customerTask['position'],
                    'is_locked' => 1,
                ]);
            }
        }

        return true;
    }
}
