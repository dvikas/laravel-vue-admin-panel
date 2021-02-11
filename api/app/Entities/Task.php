<?php

namespace App\Entities;

use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use UuidScopeTrait;

    /**
     * @var array
     */
    protected $guarded = ['id'];
    protected $with = ['parentTask'];

//    public function getRouteKeyName()
//    {
//        return 'uuid';
//    }

    public static function generateTaskIfNotExists($parentTask, $parentTaskId, $childTask, $childTaskId, $isCertificateRequired)
    {
        if ($childTaskId) {
            return self::where('uuid', $childTaskId)->firstOrFail();
        } else if (!$parentTaskId) {
            // Generate New Parent Task
            $parentTask = ParentTask::create(['name' => $parentTask, 'user_id' => auth()->id()]);
            return self::storeTask($parentTask->id, $childTask, $isCertificateRequired);
        } else if (!$childTaskId) {
            // Generate New Child Task
            $parentTask = ParentTask::byUuid($parentTaskId)->firstOrFail();
            return self::storeTask($parentTask->id, $childTask, $isCertificateRequired);
        }
    }

    public static function storeTask($parentId, $name, $isCertificateRequired)
    {
        return self::create([
            'parent_id' => $parentId,
            'name' => $name,
            'is_cert_required' => $isCertificateRequired
        ]);
    }

    public function parentTask()
    {
        return $this->belongsTo(ParentTask::class, 'parent_id', 'id');
    }

    public function draftProjectTasks()
    {
        return $this->hasMany(DraftProjectTask::class, 'task_id', 'id' );
    }

    public static function getTasksSubTasks($milestone, $isProfitShow = false)
    {
        $customerTasks = [];
        foreach ($milestone as $key => $task) {

            $customerTaskArr = [];
            $customerTasks[$key]['parent'] = $task['parent_task']['name'];
            $customerTasks[$key]['parent_id'] = $task['parent_task']['uuid'];
            $customerTasks[$key]['milestone_id'] = $task['uuid'];
            $customerTasks[$key]['start_date'] = $task['start_date'];
            $customerTasks[$key]['end_date'] = $task['end_date'];
            $customerTasks[$key]['milestone'] = $task['label'];
            $customerTasks[$key]['amount'] = $task['amount'];
            $customerTasks[$key]['notes'] = $task['notes'];

            foreach ($task['customer_tasks'] as $customerTask) {
                $customArray['sub_task'] = $customerTask['task']['name'];
                $customArray['sub_task_id'] = $customerTask['task']['uuid'];
                $customArray['is_cert_required'] = (bool) $customerTask['task']['is_cert_required'];
                $customArray['certificate_path'] = $customerTask['certificate_path'];
                $customArray['customer_sub_task_id'] = $customerTask['uuid'];
                $customArray['quantity'] = $customerTask['quantity'];
                $customArray['unit'] = $customerTask['unit'];
                $customArray['rate'] = $customerTask['rate'];
                $customArray['total'] = $customerTask['total'];
                $customArray['is_locked'] = $customerTask['is_locked'];
                if($isProfitShow === true) {
//                    if($customerTask['project_task_profits']['uuid']){
                        $customArray['project_task_profits'] = [
                            'id' => $customerTask['project_task_profits']['uuid'],
                            'quantity' => $customerTask['project_task_profits']['quantity'],
                            'unit' => $customerTask['project_task_profits']['unit'],
                            'rate' => $customerTask['project_task_profits']['rate'],
                            'total' => $customerTask['project_task_profits']['total'],
                        ];
//                    } else {
//                        $customArray['project_task_profits'] = [];
//                    }

                }
                $customerTaskArr[] = $customArray;
            }
            $customerTasks[$key]['child'] = $customerTaskArr;

            $customerTasks[$key]['newChild'] = [
                'sub_task' => '',
                'sub_task_id' => 0,
                'quantity' => '',
                'unit' => '',
                'rate' => '',
                'total' => '',
                'is_cert_required' => false,
                'certificate_path' => ''
            ];
        }
        return ($customerTasks);
    }

}
