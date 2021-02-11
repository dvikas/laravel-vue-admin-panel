<?php

namespace App\Entities;

use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    use UuidScopeTrait;

    /**
     * @var array
     */
    protected $guarded = ['uuid'];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['task', 'projectTaskProfits', 'milestone'];

    protected static function boot() {
        parent::boot();

        static::deleting(function($that) {
            $that->projectTaskProfits()->delete();
        });
    }

    public function task(){
        return $this->belongsTo(Task::class, 'task_id', 'id' );
    }

    public function milestone(){
        return $this->belongsTo(ProjectMilestone::class, 'milestone_id', 'id' );
    }

    public function projectTaskProfits(){
        return $this->hasOne(ProjectTaskProfit::class, 'project_task_id', 'id' );
    }
}
