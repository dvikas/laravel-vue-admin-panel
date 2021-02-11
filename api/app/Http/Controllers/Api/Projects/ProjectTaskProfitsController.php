<?php

namespace App\Http\Controllers\Api\Projects;

use App\Entities\Project;
use App\Entities\ProjectMilestone;
use App\Entities\ProjectTask;
use App\Entities\ProjectTaskProfit;
use App\Entities\Task;
use App\Http\Controllers\Requests\ProjectTaskProfitsFormRequest;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Dingo\Api\Facade\API;

class ProjectTaskProfitsController extends Controller
{
    use Helpers;

    public function show($projectId)
    {
        $projectObj = Project::where('uuid', $projectId)->firstOrFail();

        $taskSubTasksArr = ProjectMilestone::getProjectMilestones($projectObj->id, auth()->id());
        $taskSubTasks = Task::getTasksSubTasks($taskSubTasksArr, true);

        $status = $taskSubTasks ? 200 : 204;
        return API::response()->array($taskSubTasks)->statusCode($status);
    }

    public function store(ProjectTaskProfitsFormRequest $request)
    {
        $projectTaskUuId = $request->getData()['project_task_id'];
        $projectTaskObj = ProjectTask::where('uuid',$projectTaskUuId)->firstOrFail();

        $projectId =  $projectTaskObj->milestone->project_id;

        $projectObj = Project::find($projectId);
        $projectObj->budget_total = $request->getData()['budgetTotal'];
        $projectObj->grand_total = $request->getData()['grandTotal'];
        $projectObj->update();


        try {
            $taskProfit = ProjectTaskProfit::create([
                'project_task_id' => $projectTaskObj->id,
                'quantity' => $request->getData()['quantity'],
                'unit' => $request->getData()['unit'],
                'rate' => $request->getData()['rate'],
                'total' => $request->getData()['total'],
            ]);
        } catch (\Exception $e){
            return API::response()->array(['status'=>0, 'msg'=>'Error creating record'])->statusCode(500);
        }
        return API::response()->array(['id'=>$taskProfit->uuid, 'status'=>1])->statusCode(200);
    }

    public function update(ProjectTaskProfitsFormRequest $request, $id)
    {
        $projectTaskObj = ProjectTaskProfit::with('projectTask')->where('uuid', '=', $id )->firstOrFail();
        $projectId =  $projectTaskObj->projectTask->milestone->project_id;

        $projectObj = Project::find($projectId);
        $projectObj->budget_total = $request->getData()['budgetTotal'];
        $projectObj->grand_total = $request->getData()['grandTotal'];
        $projectObj->update();

        $projectTaskObj->update ([
            'quantity' => $request->getData()['quantity'],
            'unit' => $request->getData()['unit'],
            'rate' => $request->getData()['rate'],
            'total' => $request->getData()['total'],
        ]);
        return API::response()->array([])->statusCode(204);
    }
}
