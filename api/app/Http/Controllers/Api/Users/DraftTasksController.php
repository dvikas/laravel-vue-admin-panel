<?php

namespace App\Http\Controllers\Api\Users;

use App\Entities\Customer;
use App\Entities\Project;
use App\Entities\ProjectMilestone;
use App\Entities\DraftProjectMilestone;
use App\Entities\DraftProjectTask;
use App\Entities\DraftTask;
use App\Entities\ParentTask;
use App\Entities\Task;


use App\Transformers\Users\DraftTasksTransformer;
use Dingo\Api\Facade\API;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
/**
 * @Resource("Draft Tasks")
 */
class DraftTasksController extends Controller
{
    use Helpers;

    public function index()
    {
        $name = request()->get('query');
        if($name) {
            $tasks = DraftTask::where('name', 'like', '%' . $name . '%')
                ->where('user_id', auth()->id())
                ->paginate('');
        } else {
            $tasks = DraftTask::where('user_id', auth()->id())->get();
        }
        return $this->response->paginator($tasks, new DraftTasksTransformer());
    }

    public function store()
    {
        $request = request()->post('data');
        $draftName = request()->post('name');
        if($draftName == '') {
            return API::response()->array([])->statusCode(422);
        }
        $parentTaskPosition = 1;
        $draftTask = DraftTask::create(['name'=>$draftName, 'user_id' => auth()->id()]);
        foreach($request as $data) {
            $parentTaskObj = ParentTask::where('uuid', $data['parent_id'])->firstOrFail();
            $draftCustomerMilestoneObj = DraftProjectMilestone::create([
                'draft_task_id' => $draftTask->id,
                'task_id' => $parentTaskObj->id,
                'position' => $parentTaskPosition,
                'user_id' => auth()->id(),
            ]);
            $parentTaskPosition ++;
            $childTaskPosition = 1;
            foreach($data['child'] as $childData){
                $childTaskObj = Task::where('uuid', $childData['sub_task_id'])->firstOrFail();
                DraftProjectTask::create([
                    'task_id' => $childTaskObj->id,
                    'milestone_id' => $draftCustomerMilestoneObj->id,
                    'position' => $childTaskPosition
                ]);
                $childTaskPosition ++;
            }
        }

        return API::response()->array([])->statusCode(204);
    }

    public function show($draftUuid, $customerUuid, $projectUuid)
    {
//        $custObj = Customer::where('uuid', $customerUuid)->firstOrFail();
        $draftTaskObj = DraftTask::where('uuid',$draftUuid)->firstOrFail();
        $projectObj = Project::where('uuid',$projectUuid)->firstOrFail();

        DraftTask::setDraftTasksSubTasks($draftTaskObj->id, $projectObj->id);

        $taskSubTasks = ProjectMilestone::getCustomerTasks($projectObj->id, auth()->id());

        $status = $taskSubTasks ? 200 : 204;
        return API::response()->array($taskSubTasks)->statusCode($status);

    }
}
