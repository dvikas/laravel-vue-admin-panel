<?php

namespace App\Http\Controllers\Api\Projects;

use App\Entities\Customer;
use App\Entities\Project;
use App\Entities\SupplierProjectTask;
use App\Mail\ProjectInvoice;
use App\Transformers\Projects\ProjectTransformer;
use Dingo\Api\Facade\API;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    use Helpers;

    public function index(Request $request)
    {
        $name = $request->get('query');
        $projects = Project::with('customer');
        $projects = $projects->whereHas('customer', function($query) use ($name){
            $query->where('user_id',auth()->id());
        });


        if($name) {
            $projects = $projects->whereHas('customer', function($query) use ($name){
                $query->where('name', 'like', '%' . $name . '%');
            });
            $projects = $projects->orWhere('slug', 'like', '%' . $name . '%');
        }
        $projects = $projects->orderBy('created_at', 'desc')
            ->paginate(env('RPP'));

        return $this->response->paginator($projects, new ProjectTransformer());
    }

    public function update(Request $request, $id)
    {
        $project = Project::where('uuid', '=', $id )->firstOrFail();

        $project->update ([
            $request->post('field') =>  $request->post('value')
        ]);
        return API::response()->array([])->statusCode(204);
    }

    public function sendInvoice($projectId)
    {
        $project = Project::where('uuid', '=', $projectId )->firstOrFail();
        Mail::to($project->customer->email)->send(new ProjectInvoice($project));
    }

    public function destroy($id)
    {
        Project::deleteProject($id);

        return API::response()->array([])->statusCode(204);
    }
}
