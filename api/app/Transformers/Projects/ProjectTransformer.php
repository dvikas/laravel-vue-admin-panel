<?php

namespace App\Transformers\Projects;

use App\Entities\Customer;
use App\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{

    /**
     * @param Customer $model
     * @return array
     */
    public function transform(Project $model)
    {
        return [
            'id' => $model->uuid,
            'slug' => $model->slug,
            'block' => $model->block,
            'section' => $model->section,
            'suburb' => $model->suburb,
            'project_type' => Project::$projectType[$model->project_type],
            'property_type' => Project::$propertyType[$model->property_type],
            'status' => $model->status,
            'created_at' => $model->created_at->format('m/d/Y'),
            'customer' => $model->customer
        ];
    }
}