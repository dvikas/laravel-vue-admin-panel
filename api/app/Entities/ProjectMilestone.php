<?php

namespace App\Entities;

use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Model;

class ProjectMilestone extends Model
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
    protected $with = ['parentTask'];

//    protected static function boot() {
//        parent::boot();
//
//        static::deleting(function($that) {
//            $that->customerTasks()->delete();
//        });
//    }

    public static function deleteCustomerMilestone($custId, $milestoneUuid)
    {
        $customerMileStoneObj = ProjectMilestone::where('uuid', $milestoneUuid);
        $customerMileStone = $customerMileStoneObj->firstOrFail();
        ProjectTask::where('milestone_id',$customerMileStone->id)->delete();
        $customerMileStoneObj->delete();
    }

    public static function deleteProjectTaskSubtasks($projectId)
    {
        $customerMileStones = ProjectMilestone::where('project_id',$projectId);
        foreach($customerMileStones->get() as $mileStones) {
            ProjectTask::where('milestone_id',$mileStones->id)->delete();
        }
        $customerMileStones->delete();
    }

    public static function getCustomerTasks($projectId, $userId)
    {
        $tasks = self::getProjectMilestones($projectId, $userId);
        return Task::getTasksSubTasks($tasks);
    }

    public static function getProjectMilestones($projectId, $userId)
    {
        $tasks = ProjectMilestone::where('project_id', $projectId)
            ->where('user_id', $userId)->with(['customerTasks' => function ($q) {
                $q->orderBy('position', 'asc');
            }])->orderBy('position', 'asc')->get()->toArray();
        return $tasks;
    }

    public function customerTasks(){
        return $this->hasMany(ProjectTask::class, 'milestone_id', 'id' );
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id' );
    }

    public function parentTask(){
        return $this->belongsTo(ParentTask::class, 'task_id', 'id' );
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
