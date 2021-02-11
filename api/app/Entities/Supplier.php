<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Support\UuidScopeTrait;

class Supplier extends Model
{
    use UuidScopeTrait;

    protected $guarded = ['id'];
    protected $hidden = ['pivot'];

    function tasks() {
        return $this->belongsToMany(SupplierUserTask::class, 'supplier_tasks', 'supplier_id', 'supplier_user_task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->select(['id', 'uuid', 'name', 'phone', 'email'])
            ;
    }

}
