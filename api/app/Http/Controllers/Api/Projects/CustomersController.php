<?php

namespace App\Http\Controllers\Api\Projects;

use App\Entities\Project;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Dingo\Api\Http\Response;
use App\Entities\Customer;
use App\Http\Controllers\Controller;
use App\Transformers\Projects\CustomerTransformer;
use Illuminate\Support\Facades\Validator;

//use Illuminate\Http\Request;

class CustomersController extends Controller
{
    use Helpers;

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
//            'email' => 'required|email|unique:customers,email',
            'email' => 'required|email',
            'postal_code' => 'required',
            'address' => 'required',
            'site_postal_code' => 'required',
            'site_block' => 'required',
            'site_section' => 'required',
            'site_suburb' => 'required',
            'project_type' => 'required|in:new,renovation,extension',
            'property_type' => 'required|in:investment,owner_occupier'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        } else {
            $customer = Customer::create([
                'name' => $request->post('name'),
                'phone' => $request->post('phone'),
                'email' => $request->post('email'),
                'postal_code' => $request->post('postal_code'),
                'address' => $request->post('address'),
                'is_children' => $request->post('is_children'),
                'is_family' => $request->post('is_family'),
                'family_members' => (int)$request->post('family_members'),
                'children' => (int)$request->post('children'),
                'user_id' => auth()->id()
            ]);

            $slug = Project::getSlug($request->post('site_block'),
                $request->post('site_section'),
                $request->post('site_suburb')
            );
            $propertyType = array_search($request->post('property_type'), Project::$propertyType);
            $projectType = array_search($request->post('project_type'), Project::$projectType);

            $postedData = [
                'postal_code' => $request->post('site_postal_code'),
                'block' => $request->post('site_block'),
                'section' => $request->post('site_section'),
                'suburb' => $request->post('site_suburb'),
                'slug' => $slug,
                'customer_id' => $customer->id,
                'project_type' => $projectType,
                'property_type' => $propertyType,
                'arch_plan_file' => '',
                'engg_plan_file' => '',
                'energy_eff_file' => '',
                'tab_2_enabled' => 1
                ];

            Project::create($postedData);

            return $this->response->item($customer->fresh(), new CustomerTransformer());
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $rules = [
            'id' => 'required',
            'name' => 'required',
            'phone' => 'required',
//            'email' => 'required|email|unique:customers,email',
            'email' => 'required|email',
            'postal_code' => 'required',
            'address' => 'required',
            'site_postal_code' => 'required',
            'site_block' => 'required',
            'site_section' => 'required',
            'site_suburb' => 'required',
            'project_type' => 'required|in:new,renovation,extension',
            'property_type' => 'required|in:investment,owner_occupier'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        } else {
            $customer = Customer::where('uuid', '=', $request->post('id') )->first();
            if(!$customer) {
                return response()->json(['errors' => 'Customer doesn\'t exists'], 422);
            }
            $customer->name = $request->post('name');
            $customer->phone = $request->post('phone');
            $customer->email = $request->post('email');
            $customer->postal_code = $request->post('postal_code');
            $customer->address = $request->post('address');
            $customer->is_children = $request->post('is_children');
            $customer->is_family = $request->post('is_family');
            $customer->family_members = $request->post('family_members');
            $customer->children = $request->post('children');

            $slug = Project::getSlug($request->post('site_block'),
                $request->post('site_section'),
                $request->post('site_suburb')
            );
            $propertyType = array_search($request->post('property_type'), Project::$propertyType);
            $projectType = array_search($request->post('project_type'), Project::$projectType);

            $postedData = [
                'postal_code' => $request->post('site_postal_code'),
                'block' => $request->post('site_block'),
                'section' => $request->post('site_section'),
                'suburb' => $request->post('site_suburb'),
                'slug' => $slug,
                'customer_id' => $customer->id,
                'project_type' => $projectType,
                'property_type' => $propertyType
                ];

            $customer->projectDetails()->update($postedData);
            $customer->save();

            return $this->response->item($customer, new CustomerTransformer());
        }

    }

    public function show($id)
    {
        $customer = Customer::with('projectDetails')->where('uuid', $id)->get();
        return $this->response->collection($customer, new CustomerTransformer());
    }
}
