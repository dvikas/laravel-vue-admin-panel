<?php

namespace App\Transformers\Users;

use App\Entities\User;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer.
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = ['roles'];

    /**
     * @param User $model
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id' => $model->uuid,
            'name' => $model->name,
            'email' => $model->email,
            'phone' => $model->phone,
            'address' => $model->address,
//            'created_at' => $model->created_at->toIso8601String(),
//            'updated_at' => $model->updated_at->toIso8601String(),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
            'role' => $model->roles[0]->name,
            'avatar' => $model->avatar,
        ];
    }

    /**
     * @param User $model
     * @return \League\Fractal\Resource\Collection
     */
    public function includeRoles(User $model)
    {
        return $this->collection($model->roles, new RoleTransformer());
    }
}
