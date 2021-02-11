<?php

namespace App\Entities;

use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Model;


class DraftProjectTask extends Model
{
    use UuidScopeTrait;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    protected $with = ['task'];

    public function task(){
        return $this->belongsTo(Task::class, 'task_id', 'id' );
    }

}
