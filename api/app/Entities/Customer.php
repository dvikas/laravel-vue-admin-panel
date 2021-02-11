<?php

namespace App\Entities;

use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use UuidScopeTrait;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    public function projectDetails(){
        return $this->hasOne(Project::class, 'customer_id', 'id' );
    }

    public function projects(){
        return $this->hasMany(Project::class, 'customer_id', 'id' )
            ->select(['id','uuid','customer_id', 'slug', 'postal_code', 'block', 'section', 'suburb', 'status']);
    }


    public function customerTasks(){
        return $this->hasMany(ProjectTask::class, 'customer_id', 'id' );
    }
}
