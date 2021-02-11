<?php

namespace App\Entities;

use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    use UuidScopeTrait;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    public static $propertyType = [1 => 'investment', 2 => 'owner_occupier'];

    public static $projectType = [1 => 'new', 2 => 'renovation', 3 => 'extension'];

    protected static function boot() {
        parent::boot();

        static::deleting(function($project) {
            $project->projectQuotes()->delete();
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')
            ->select(['id', 'uuid', 'name', 'phone', 'email', 'postal_code']);
    }

    public function projectMilestones(){
        return $this->hasMany(ProjectMilestone::class, 'project_id', 'id' );
    }

    public function supplierProjectTasks(){
        return $this->hasMany(SupplierProjectTask::class, 'project_id', 'id' );
    }

    public function projectQuotes(){
        return $this->hasOne(ProjectQuote::class, 'project_id', 'id' );
    }

    public static function getSlug($block, $section, $suburb)
    {
        return trim($block).'-'.trim($section).'-'.trim($suburb);
    }

    public static function deleteProject($id)
    {
        $project = Project::whereUuid($id )->firstOrFail();
        $customerId = $project->customer_id;
        foreach($project->supplierProjectTasks as $supplierProjectTask){
            $supplierProjectTask->delete();
        }
        foreach($project->projectMilestones as $projectMilestone){
            foreach($projectMilestone->customerTasks as $projectTask) {
                $projectTask->delete();
            }
            $projectMilestone->delete();
        }

        $project->delete();

        Customer::find($customerId)->delete();
    }
}
