<?php

namespace App\Http\Controllers\Api\Projects;

use App\Entities\Customer;
use App\Transformers\Projects\ProjectDetailTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Dingo\Api\Http\Response;
use App\Entities\Project;
use App\Http\Controllers\Controller;
use App\Transformers\Projects\ProjectDetailsTransformer;
use Illuminate\Support\Facades\Validator;

//use Illuminate\Http\Request;

class ProjectDetailsController extends Controller
{
    use Helpers;

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $rules = [
            'postal_code' => 'required',
            'block' => 'required',
            'section' => 'required',
            'suburb' => 'required',
            'project_type' => 'required|in:new,renovation,extension',
            'property_type' => 'required|in:investment,owner_occupier'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }
        $customer = Customer::byUuid($request->post('customer_id'))->firstOrFail();

        $slug = self::getSlug($request->post('block'),
            $request->post('section'),
            $request->post('suburb')
        );

        $propertyType = array_search($request->post('property_type'), Project::$propertyType);
        $projectType = array_search($request->post('project_type'), Project::$projectType);

        $postedData = array_merge($request->all(),
            array(
                'slug' => $slug,
                'customer_id' => $customer->id,
                'project_type' => $projectType,
                'property_type' => $propertyType

            ));
        $user = Project::create($postedData);
        return $this->response->item($user->fresh(), new ProjectDetailTransformer());
    }

    private static function getSlug($block, $section, $suburb)
    {
        return trim($block).'-'.trim($section).'-'.trim($suburb);
    }

    public function show($id)
    {

    }
}
