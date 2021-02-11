<?php

namespace App\Http\Controllers\Api\Projects;

use App\Entities\Project;
use App\Entities\ProjectMilestone;
use App\Entities\ProjectTask;
use App\Entities\ParentTask;
use App\Entities\Task;
use App\Http\Controllers\Requests\CustomerTasksFormRequest;
use App\Transformers\Projects\CustomerTaskTransformer;
use Dingo\Api\Facade\API;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Dingo\Api\Http\Response;
use App\Entities\Customer;
use App\Http\Controllers\Controller;
use App\Transformers\Projects\CustomerTransformer;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/**
 * @Resource("Customer Tasks")
 */
class ProjectTasksController extends Controller
{
    use Helpers;

    /**
     * Add customer's sub-task
     *
     * @Post("/")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({
                "customer_id":"1f9b81c0-2837-11e8-89ad-c3d72b04bf87",
                "parent_task":"Drawing Room",
                "parent_task_id":"d1b2f0c0-15f2-11e8-b15a-d7ab2ac3a6c7",
                "child_task":"Child Drawing Room 2",
                "child_task_id":"d7157fa0-15f2-11e8-a15f-5372bed2ba95",
                "quantity":"12",
                "unit":"12",
                "rate":"12",
                "total":"12",
                "certificate_path":"null"
     *     }),
     *      @Response(200),
     * })
     */
    public function store(CustomerTasksFormRequest $request)
    {
        $taskObj = Task::generateTaskIfNotExists(
            $request->getData()['parent_task'],
            $request->getData()['parent_task_id'],
            $request->getData()['child_task'],
            $request->getData()['child_task_id'],
            $request->getData()['is_cert_required']
        );

        $projectUuid = $request->getData()['project_id'];
        $projectObj = Project::where('uuid', $projectUuid)->firstOrFail();

        $milestoneObj = ProjectMilestone::where([
            'project_id' => $projectObj->id ,
            'user_id' => Auth::user()->id,
            'task_id' => $taskObj->parent_id]
        )->first();

        if( empty($milestoneObj) ){
            $milestoneObj = ProjectMilestone::create([
                'task_id' => $taskObj->parent_id,
                'user_id' => Auth::user()->id,
                'position' => $request->getData()['parent_position'],
                'project_id' => $projectObj->id,
                'notes' => '',
                'amount' => 0,
            ]);
        }

        $isLocked = isset($request->getData()['isVariation']) && $request->getData()['isVariation'] == 1 ? 0 : 1;

        $postedData = array(
                'task_id' => $taskObj->id,
                'milestone_id' => $milestoneObj->id,
                'quantity' => $request->getData()['quantity'],
                'unit' => $request->getData()['unit'],
                'rate' => $request->getData()['rate'],
                'total' => $request->getData()['total'],
                'certificate_path' => $request->getData()['certificate_path'],
                'position' => $request->getData()['child_position'],
                'is_locked' => $isLocked,
        );
        $customerTask = ProjectTask::create($postedData);

        return $this->response->item($customerTask->fresh(), new CustomerTaskTransformer());

    }
    /**
     * Fetch customer's task/ sub-task
     *
     * @Get("/tasks/1f9b81c0-2837-11e8-89ad-c3d72b04bf87")
     * @Versions({"v1"})
     * @Response(200)
     */
    public function show($customerId, $projectId)
    {
//        $custObj = Customer::where('uuid', $customerId)->firstOrFail();
        $projectObj = Project::where('uuid', $projectId)->firstOrFail();

        $taskSubTasks = ProjectMilestone::getCustomerTasks($projectObj->id, auth()->id());

        $status = $taskSubTasks ? 200 : 204;
        return API::response()->array($taskSubTasks)->statusCode($status);
    }

    public function updateSubTaskPosition()
    {
        $position = 1;
        foreach(request()->post('data') as $data) {
            ProjectTask::where('uuid', $data['customer_sub_task_id'])
                ->update(['position' => $position]);
            $position++;
        }
        return API::response()->array([])->statusCode(204);
    }

    public function updateMilestonePosition()
    {
        $position = 1;
        foreach(request()->post('data') as $data) {
            ProjectMilestone::where('uuid', $data['milestone_id'])
                ->update(['position' => $position]);
            $position++;
        }
        return API::response()->array([])->statusCode(204);
    }

    /**
     * Update customer's sub-task Field
     *
     * @Put("/tasks/update-sub-task-element")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({
                    "customerId": "36b8f0c0-15f6-11e8-96d2-1f3fc52badec",
                    "customerSubTaskId": "7c113740-301f-11e8-a521-b32a2bec7338",
                    "name": "quantity",
                    "value": "42",
     *     }),
     *      @Response(204),
     * })
     */
    public function updateSubTaskElement()
    {
        $customerUuid = request()->post('customerId');

        Customer::where('uuid', $customerUuid)->firstOrFail();

        $name = request()->post('name');
        $value = request()->post('value');
        $customerSubTaskId = request()->post('customerSubTaskId');

        ProjectTask::where('uuid', $customerSubTaskId)
            ->update([$name => $value]);

        return API::response()->array([])->statusCode(204);
    }

    public function updateSubTask()
    {
        $customerUuid = request()->post('customerId');

        Customer::where('uuid', $customerUuid)->firstOrFail();

        $subTask = request()->post('subTask');
        $subTaskUuid = request()->post('subTaskId');
        $parentTaskUuid = request()->post('parentTaskId');
        $customerSubTaskId = request()->post('customerSubTaskId');

        if ($subTaskUuid === 0) { /* create new sub task*/
            $parentTask = ParentTask::where('uuid', $parentTaskUuid)->firstOrFail();
            $subTaskObj = Task::create([
                'parent_id' => $parentTask->id,
                'name' => $subTask,
                'is_cert_required' => false
            ]);
        } else {
            $subTaskObj = Task::where('uuid', $subTaskUuid)->firstOrFail();
        }

        $subTaskId = $subTaskObj->id;
        ProjectTask::where('uuid', $customerSubTaskId)
                ->update(['task_id' => $subTaskId,'certificate_path' => '']);

        return API::response()->array([])->statusCode(204);
    }

    public function updateMilestoneElement()
    {
        $customerUuid = request()->post('customerId');

        Customer::where('uuid', $customerUuid)->firstOrFail();

        $name = request()->post('name');
        $value = request()->post('value');
        $customerMileStoneId = request()->post('customerMileStoneId');

        $projectMilestone = ProjectMilestone::where('uuid', $customerMileStoneId);
        $projectMilestone->firstOrFail();
        $projectMilestone->update([$name => $value]);

        return API::response()->array([])->statusCode(204);
    }

    public function deleteSubTask()
    {
        $customerUuid = request()->post('customerId');
        $customerSubTaskId = request()->post('subTaskId');

        Customer::where('uuid', $customerUuid)->firstOrFail();
        $customerSubTask = ProjectTask::where('uuid', $customerSubTaskId);
//        $subTaskArray = $customerSubTask->firstOrFail()->toArray();

//        $customerSubTaskCount = ProjectTask::where('milestone_id', $subTaskArray['milestone_id'])->count();
        $customerSubTask->delete();
//        if($customerSubTaskCount == 1){
//            ProjectMilestone::where('id', $subTaskArray['milestone_id'])
//                ->delete();
//        }
        return API::response()->array([])->statusCode(204);
    }
    public function deleteParentTask()
    {
        $customerUuid = request()->post('customerId');
        $milestoneUuid = request()->post('milestoneId');
        $custObj = Customer::where('uuid', $customerUuid)->firstOrFail();

        ProjectMilestone::deleteCustomerMilestone($custObj->id, $milestoneUuid);
        return API::response()->array([])->statusCode(204);
    }
}
