<?php

namespace App\Http\Controllers\Api\Projects;

use App\Entities\Supplier;
use App\Entities\SupplierProjectTask;
use App\Entities\SupplierQuoteDetail;
use App\Mail\SupplierSubmittedProposal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $supplierProjectTaskUuid, $supplierUuid )
    {
        $supplierProjectTaskObj = SupplierProjectTask::whereUuid($supplierProjectTaskUuid)->firstOrFail();
        $supplierObj = Supplier::whereUuid($supplierUuid)->firstOrFail();
        $supplierQuoteDetailObj = SupplierQuoteDetail::where('supplier_id',$supplierObj->id)
            ->where('supplier_project_task_id',$supplierProjectTaskObj->id)
            ->firstOrFail();
        $supplierQuoteDetailObj->supplier_notes = $request->post('message');
        $supplierQuoteDetailObj->supplier_rate = $request->post('rate');
        $supplierQuoteDetailObj->supplier_total = $request->post('total');
        $supplierQuoteDetailObj->accepted_at = date('Y-m-d H:i:s');
        $supplierQuoteDetailObj->status = 1;
        $supplierQuoteDetailObj->update();

        Mail::to($supplierObj->user->email)
            ->send(new SupplierSubmittedProposal($supplierObj, $supplierQuoteDetailObj, $supplierProjectTaskObj));

        return view('proposal.show',[
            'supplierProjectTask' => $supplierProjectTaskObj,
            'supplier' => $supplierObj,
            'supplierQuoteDetail' => $supplierQuoteDetailObj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($supplierProjectTaskUuid, $supplierUuid)
    {
        $supplierProjectTaskObj = SupplierProjectTask::whereUuid($supplierProjectTaskUuid)->firstOrFail();
        $supplierObj = Supplier::whereUuid($supplierUuid)->firstOrFail();
        $supplierQuoteDetailObj = SupplierQuoteDetail::where('supplier_id',$supplierObj->id)
            ->where('supplier_project_task_id',$supplierProjectTaskObj->id)
                ->firstOrFail();

        return view('proposal.show',[
            'supplierProjectTask' => $supplierProjectTaskObj,
            'supplier' => $supplierObj,
            'supplierQuoteDetail' => $supplierQuoteDetailObj
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
