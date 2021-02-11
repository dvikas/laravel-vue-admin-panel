<?php

namespace App\Transformers\Projects;

use App\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectDetailTransformer extends TransformerAbstract
{
    /**
     * @param Project $model
     * @return array
     */
    public function transform(Project $model)
    {
        return [
            'id' => $model->uuid,
            'slug' => $model->slug,
            'postal_code' => $model->postal_code,
            'block' => $model->block,
            'section' => $model->section,
            'suburb' => $model->suburb,
            'arch_plan_file' => $model->arch_plan_file,
            'engg_plan_file' => $model->engg_plan_file,
            'energy_eff_file' => $model->energy_eff_file,
            'created_at' => $model->created_at->format('m-d-Y'),
            'status' => $model->status,
            'tab_2_enabled' => $model->tab_2_enabled,
            'tab_3_enabled' => $model->tab_3_enabled,
            'tab_4_enabled' => $model->tab_4_enabled,
            'tab_5_enabled' => $model->tab_5_enabled,
            'tab_6_enabled' => $model->tab_6_enabled,
            'project_type' => Project::$projectType[$model->project_type],
            'property_type' => Project::$propertyType[$model->property_type]
        ];
    }

}
