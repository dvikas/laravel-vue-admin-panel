<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Support\UuidScopeTrait;

class SupplierUserTask extends Model
{
    use UuidScopeTrait;

    protected $guarded = ['id'];
    protected $hidden = ['pivot'];

    public function suppliers() {
        return $this->belongsToMany(Supplier::class, 'supplier_tasks', 'supplier_user_task_id', 'supplier_id');
    }
}
