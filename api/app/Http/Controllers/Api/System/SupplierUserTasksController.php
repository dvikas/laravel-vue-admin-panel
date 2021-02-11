<?php

namespace App\Http\Controllers\Api\System;

use App\Entities\SupplierUserTask;
use App\Http\Controllers\Requests\SupplierUserTasksFormRequest;
use App\Transformers\System\SupplierUserTaskTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Dingo\Api\Http\Response;
use App\Http\Controllers\Controller;
use Dingo\Api\Facade\API;
use Illuminate\Support\Facades\Config;

class SupplierUserTasksController extends Controller
{
    use Helpers;

    protected $rpp;

    public function index(Request $request)
    {
        $name = $request->get('query');
        if($name) {
            $suppliers = SupplierUserTask::with(array('suppliers'=>function($query){
                $query->select('uuid','name','email');
            }))
                ->where('name', 'like', '%' . $name . '%');
        } else {
            $suppliers = SupplierUserTask::with(array('suppliers'=>function($query){
                $query->select('uuid','name','email');
            }));
        }
        $suppliers = $suppliers->where('user_id', auth()->id())
        ->where('is_active', 1)
        ->orderBy('name')
        ->paginate(env('RPP'));
        return $this->response->paginator($suppliers, new SupplierUserTaskTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function store(SupplierUserTasksFormRequest $request)
    {
        $supplier = SupplierUserTask::create([
            'user_id' =>  auth()->id(),
            'name' =>  $request->getData()['name']
        ]);
        return API::response()->array(['id'=>$supplier->uuid, 'status'=>1])->statusCode(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function update(SupplierUserTasksFormRequest $request, $id)
    {
        $supplier = SupplierUserTask::where('uuid', '=', $id )
            ->where('user_id', '=', auth()->id() )->firstOrFail();

        $supplier->update ([
            'name' =>  $request->getData()['name']
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
        $supplier = SupplierUserTask::where('uuid', '=', $id )->firstOrFail();

        $supplier->update ([
            'is_active' =>  0,
        ]);
        $supplier->suppliers()->sync([]);

        return API::response()->array([])->statusCode(204);
    }
}
