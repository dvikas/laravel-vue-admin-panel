<?php

namespace App\Http\Controllers\Api\System;

use App\Entities\ParentTask;
use App\Transformers\System\ParentTaskTransformer;
use Dingo\Api\Facade\API;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Dingo\Api\Http\Response;
use App\Http\Controllers\Controller;

use App\Entities\Task;
use App\Transformers\System\TaskTransformer;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    use Helpers;

    public function index(Request $request)
    {
        $name = $request->get('query');
        if($name) {
            $tasks = ParentTask::where('name', 'like', '%' . $name . '%')
                ->where('user_id', auth()->id())->paginate('10');
        } else {
            $tasks = ParentTask::where('user_id', auth()->id())->paginate('10');
        }
        return $this->response->paginator($tasks, new ParentTaskTransformer());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $rules = [
            'parent_id' => 'required',
            'name' => 'required',
            ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $parentId = $request->post('parent_id')?
            Task::byUuid($request->post('parent_id'))->firstOrFail()->id : 0;

        $postedData = array_merge($request->all(),
            array(
                'parent_id' => $parentId
            ));
        $task = Task::create($postedData);
        return $this->response->item($task->fresh(), new TaskTransformer());
    }

    public function show($uuid)
    {
        $task = Task::byUuid($uuid)->firstOrFail();
        return $this->response->item($task->fresh(), new TaskTransformer());
    }

    public function getChildren($uuid, Request $request)
    {
        $parentTaskId = ParentTask::byUuid($uuid)->firstOrFail()->id;

        $name = $request->get('query');
        if($name) {
            $andWhere = [['parent_id', '=', $parentTaskId],
                ['name', 'like', '%' . $name . '%']];
        } else {
            $andWhere = [['parent_id', '=', $parentTaskId]];
        }
        $children = Task::where($andWhere)->paginate('');
        return $this->response->paginator($children, new TaskTransformer($uuid));
    }
}
