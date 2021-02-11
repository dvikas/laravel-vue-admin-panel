<?php

namespace App\Entities;

use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Model;


class ParentTask extends Model
{
    use UuidScopeTrait;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'parent_id', 'id' );
    }
    public function draftProjectMilestones()
    {
        return $this->hasMany(DraftProjectMilestone::class, 'task_id', 'id' );
    }
}
