<?php

namespace App\Transformers\Projects;

use App\Entities\Customer;
use App\Entities\Project;
use League\Fractal\TransformerAbstract;

/**
 * Class CustomerTransformer.
 */
class CustomerTransformer extends TransformerAbstract
{
    /**
     * @param Customer $model
     * @return array
     */
    public function transform(Customer $model)
    {
        return [
            'id' => $model->uuid,
            'name' => $model->name,
            'phone' => $model->phone,
            'email' => $model->email,
            'postal_code' => $model->postal_code,
            'address' => $model->address,
            'is_children' => $model->is_children,
            'children' => $model->children,
            'is_family' => $model->is_family,
            'family_members' => $model->family_members,
            'project_details' => [
                'id' => $model->projectDetails['uuid'],
                'postal_code' => $model->projectDetails['postal_code'],
                'block' => $model->projectDetails['block'],
                'section' => $model->projectDetails['section'],
                'suburb' => $model->projectDetails['suburb'],
                'slug' => $model->projectDetails['slug'],
                'project_type' => Project::$projectType[$model->projectDetails['project_type']],
                'property_type' => Project::$propertyType[$model->projectDetails['property_type']],
                'status' => $model->projectDetails['status'],
                'arch_plan_file' => $model->projectDetails['arch_plan_file'],
                'engg_plan_file' => $model->projectDetails['engg_plan_file'],
                'energy_eff_file' => $model->projectDetails['energy_eff_file'],
                'tab_2_enabled' => $model->projectDetails['tab_2_enabled'],
                'tab_3_enabled' => $model->projectDetails['tab_3_enabled'],
                'tab_4_enabled' => $model->projectDetails['tab_4_enabled'],
                'tab_5_enabled' => $model->projectDetails['tab_5_enabled'],
                'tab_6_enabled' => $model->projectDetails['tab_6_enabled'],
                'created_at' => $model->created_at->format('m-d-Y'),
            ]
        ];
    }

}
