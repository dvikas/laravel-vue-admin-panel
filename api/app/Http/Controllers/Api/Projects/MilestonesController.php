<?php

namespace App\Http\Controllers\Api\Projects;

use App\Entities\ProjectTask;
use App\Entities\ProjectMilestone;
use App\Entities\Task;
use App\Transformers\Projects\CustomerTaskTransformer;
use App\Transformers\Projects\MilestoneTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Dingo\Api\Http\Response;
use App\Entities\Customer;
use App\Http\Controllers\Controller;
use App\Transformers\Projects\CustomerTransformer;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class MilestonesController extends Controller
{
    use Helpers;

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {

        foreach($request->all() as $req){

            $taskUuId = $req['task_id'];
            $custUuId = $req['customer_id'];
            if(!$taskUuId || !$custUuId) {
                return response()->json(['errors'=>'Invalid Data'], 422);
            }

            $taskObj = Task::where('uuid', $taskUuId)->firstOrFail();

            $custObj = Customer::where('uuid', $custUuId)->firstOrFail();

            if(!$taskObj || !$custObj) {
                return response()->json(['errors'=>'Invalid Data'], 422);
            }

            $postedData = array_merge($req,
                array(
                    'customer_id' => $custObj->id,
                    'task_id' => $taskObj->id
                ));

            ProjectMilestone::create($postedData);
        }
        return $this->response->accepted();

    }

    public function show($id)
    {
        $postCodes = Customer::where('postcode', $id)->paginate('');
        return $this->response->paginator($postCodes, new CustomerTransformer());
    }
}
