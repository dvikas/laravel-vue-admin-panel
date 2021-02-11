<?php

namespace App\Http\Controllers\Api\Projects;

use App\Entities\Supplier;
use App\Entities\SupplierProjectTask;
use App\Entities\SupplierQuoteDetail;
use App\Mail\SupplierQuoteInvitation;
//use App\Notifications\SupplierQuote;
use Dingo\Api\Facade\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SupplierQuoteDetailsController extends Controller
{
    public function store(Request $request)
    {
        $supplierProjectTaskUuId = $request->post('id');
        $suppliers = $request->post('suppliers');
        $notes = $request->post('notes');

        try {
            $supplierProjectTaskObj = SupplierProjectTask::where('uuid',$supplierProjectTaskUuId)->firstOrFail();
            foreach($suppliers as $supplier) {
                $supplierObj = Supplier::where('uuid',$supplier)->firstOrFail();

                SupplierQuoteDetail::where('supplier_id', $supplierObj->id)
                    ->where('supplier_project_task_id', $supplierProjectTaskObj->id)
                    ->delete();

                $supplierQuote = SupplierQuoteDetail::create([
                    'supplier_id' =>  $supplierObj->id,
                    'supplier_project_task_id' =>  $supplierProjectTaskObj->id,
                    'user_notes' =>  $notes,
                    'sent_at' =>  date('Y-m-d H:i:s'),
                    'status' =>  0,
                    'is_active' =>  1,
                ]);
//                https://laracasts.com/series/laravel-from-scratch-2017/episodes/26?autoplay=true
//                php artisan make:mail SupplierQuoteInvitation --markdown="emails.supplier-quote-invitation"
                /**********************************/
                Mail::to($supplierObj->email)
                    ->send(new SupplierQuoteInvitation($supplierObj, $supplierQuote, $supplierProjectTaskObj));
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }


        return API::response()->array(['status'=>1])->statusCode(200);
    }
}
