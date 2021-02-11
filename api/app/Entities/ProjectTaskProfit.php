<?php

namespace App\Entities;

use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Model;

class ProjectTaskProfit extends Model
{
    use UuidScopeTrait;

    /**
     * @var array
     */
    protected $guarded = ['uuid'];

    public function projectTask()
    {
        return $this->belongsTo(ProjectTask::class, 'project_task_id', 'id')
            ->select(['id', 'uuid', 'task_id', 'milestone_id', 'position', 'quantity', 'unit', 'rate', 'total', 'certificate_path', 'is_locked']);
    }
}
