<?php

namespace App\Entities;

use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Model;


class DraftProjectMilestone extends Model
{
    use UuidScopeTrait;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    public function draftCustomerTasks(){
        return $this->hasMany(DraftProjectTask::class, 'milestone_id', 'id' );
    }
}
