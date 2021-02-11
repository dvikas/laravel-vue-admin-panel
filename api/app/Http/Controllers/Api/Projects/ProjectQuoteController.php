<?php

namespace App\Http\Controllers\Api\Projects;

use App\Entities\Project;
use App\Entities\ProjectQuote;
use App\Transformers\Projects\ProjectQuoteTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Facade\API;

class ProjectQuoteController extends Controller
{
    use Helpers;

    public function store(Request $request,$projectUuid)
    {
        $projectObj = Project::where('uuid', $projectUuid)->firstOrFail();
        try {
            $quote = ProjectQuote::create([
                'project_id' => $projectObj->id,
                'email_received' => $request->post('email_received'),
                'amount_received' => $request->post('amount_received'),
                'payment_details' => $request->post('payment_details'),
                'document' => $request->post('document'),
            ]);
            $projectObj->status = 1;
            $projectObj->tab_4_enabled = 1;
            $projectObj->tab_5_enabled = 1;
            $projectObj->tab_6_enabled = 1;
            $projectObj->update();
            return API::response()->array([
                    'id' => $quote->uuid,
                    'accepted_date' => $quote->created_at->format('m-d-Y'),
                    'status' => 1
                ]
            )->statusCode(200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 422);
            return response("An Error Occured, please retry later", 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $projectId
     * @return \Illuminate\Http\Response
     */
    public function show($projectUuid)
    {
        try {
            $projectObj = Project::where('uuid',$projectUuid)->firstOrFail();
            $projectQuoteObj = ProjectQuote::where('project_id',$projectObj->id)->firstOrFail();
            return $this->response->item($projectQuoteObj, new ProjectQuoteTransformer());
        } catch (\Exception $e) {
            return response("An Error Occured, please retry later", 422);
        }

    }

}
