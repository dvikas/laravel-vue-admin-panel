<?php

namespace App\Http\Controllers\Api\System;

use App\Entities\SupplierUserTask;
use Dingo\Api\Routing\Helpers;
use App\Entities\Supplier;
use App\Http\Controllers\Requests\SuppliersFormRequest;
use App\Transformers\System\SupplierTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Facade\API;

class SuppliersController extends Controller
{
    use Helpers;

    public function index(Request $request)
    {
        $name = $request->get('query');
        if($name) {
            $suppliers = Supplier::with(array('tasks'=>function($query){
                $query->select('uuid','name');
            }))
            ->where('name', 'like', '%' . $name . '%');
        } else {
            $suppliers = Supplier::with(array('tasks'=>function($query){
                $query->select('uuid','name');
            }));
        }
        $suppliers = $suppliers->where('user_id', auth()->id())
            ->where('is_active', 1)
            ->orderBy('name')
            ->paginate(env('RPP'));
        return $this->response->paginator($suppliers, new SupplierTransformer());
    }

    public function store(SuppliersFormRequest $request)
    {
        $supplierUserTasks = SupplierUserTask::whereIn('uuid',request()->post('selectedSuppliersTasks'))->get();
        $supplierTaskArr = [];
        foreach($supplierUserTasks as $supplierTask){
            $supplierTaskArr[] = ($supplierTask->id);
        }

        $supplier = Supplier::create([
           'user_id' =>  auth()->id(),
           'name' =>  $request->getData()['name'],
           'email' =>  $request->getData()['email'],
           'phone' =>  $request->getData()['phone'],
           'address' =>  $request->getData()['address'],
           'abn' =>  $request->getData()['abn'],
           'acn' =>  $request->getData()['acn'],
        ]);
        $supplier->tasks()->sync($supplierTaskArr);

        return $this->response->item($supplier, new SupplierTransformer());
    }

    public function update(SuppliersFormRequest $request, $id)
    {
        $supplier = Supplier::where('uuid', '=', $id )->firstOrFail();

        $supplierUserTasks = SupplierUserTask::whereIn('uuid',request()->post('selectedSuppliersTasks'))->get();
        $supplierTaskArr = [];
        foreach($supplierUserTasks as $supplierTask){
            $supplierTaskArr[] = ($supplierTask->id);
        }
        $supplier->update ([
            'name' =>  $request->getData()['name'],
            'email' =>  $request->getData()['email'],
            'phone' =>  $request->getData()['phone'],
            'address' =>  $request->getData()['address'],
            'abn' =>  $request->getData()['abn'],
            'acn' =>  $request->getData()['acn'],
        ]);
        $supplier->tasks()->sync($supplierTaskArr);

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
        $supplier = Supplier::where('uuid', '=', $id )->firstOrFail();

        $supplier->update ([
            'is_active' =>  0,
        ]);
        $supplier->tasks()->sync([]);
        return API::response()->array([])->statusCode(204);
    }
}
