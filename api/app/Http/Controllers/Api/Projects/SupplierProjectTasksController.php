<?php

namespace App\Http\Controllers\Api\Projects;

use App\Entities\Project;
use App\Entities\SupplierProjectTask;
use App\Entities\SupplierUserTask;
use App\Http\Controllers\Requests\SupplierProjectTasksFormRequest;
use App\Transformers\Projects\SupplierProjectTaskTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Facade\API;
use Illuminate\Support\Facades\Config;

class SupplierProjectTasksController extends Controller
{
    use Helpers;

    protected $rpp;
    /**
     * SuppliersController constructor.
     */
    public function __construct()
    {
        $this->rpp = Config::get('RPP');
    }

    public function index(Request $request, $projectId)
    {
        $name = $request->get('query');
        $projectId = Project::where('uuid',$projectId)->firstOrFail()->id;
        if($name) {
            $suppliers = SupplierProjectTask::with('supplierUserTask')->with('supplierQuoteDetails')
                ->where('name', 'like', '%' . $name . '%')
                ->where('project_id', $projectId)
                ->paginate($this->rpp);
        } else {
            $suppliers = SupplierProjectTask::with('supplierUserTask')
                ->where('project_id', $projectId)
                ->paginate($this->rpp);
        }
        return $this->response->paginator($suppliers, new SupplierProjectTaskTransformer());
    }

    public function store(SupplierProjectTasksFormRequest $request)
    {
        $supplyUserTaskUuId = $request->getData()['supplier_user_task_id'];
        $projectUuid = $request->getData()['project_id'];
        $supplierUserTaskObj = SupplierUserTask::where('uuid',$supplyUserTaskUuId)->firstOrFail();
        $projectObj = Project::where('uuid',$projectUuid)->firstOrFail();

        $supplier = SupplierProjectTask::create([
            'supplier_user_task_id' =>  $supplierUserTaskObj->id,
            'project_id' =>  $projectObj->id,
            'quantity' =>  $request->getData()['quantity'],
            'unit' =>  $request->getData()['unit'],
            'deadline' =>  $request->getData()['deadline'],
        ]);
        return API::response()->array(['id'=>$supplier->uuid, 'status'=>1])->statusCode(200);
    }

    public function update(SupplierProjectTasksFormRequest $request, $id)
    {
        $supplier = SupplierProjectTask::where('uuid', '=', $id )->firstOrFail();

        $supplyUserTaskUuId = $request->getData()['supplier_user_task_id'];
        $supplierUserTaskObj = SupplierUserTask::where('uuid',$supplyUserTaskUuId)->firstOrFail();

        $supplier->update ([
            'supplier_user_task_id' =>  $supplierUserTaskObj->id,
            'quantity' =>  $request->getData()['quantity'],
            'unit' =>  $request->getData()['unit'],
            'deadline' =>  $request->getData()['deadline']
        ]);
        return API::response()->array([])->statusCode(204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = SupplierProjectTask::where('uuid', '=', $id )->firstOrFail();

        $supplier->delete();
        return API::response()->array([])->statusCode(204);
    }
}
