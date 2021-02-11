<?php

namespace App\Http\Controllers\Api;


use App\Entities\Customer;
use App\Entities\Project;
use App\Entities\SupplierProjectTask;
use App\Mail\ProjectInvoice;
use App\Transformers\Projects\ProjectTransformer;
use Dingo\Api\Facade\API;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    use Helpers;

    public function chartData()
    {
        $projects = Project::with('customer');
        $projects = $projects->whereHas('customer', function($query){
            $query->where('user_id',auth()->id());
        })->where('status','=', 1);

        $matchGroups = $projects->orderBy('created_at','asc')->get()->groupBy(function($item) {
            return $item->created_at->format('Y-M');
        })->take(7);

        $monthArray = [];
        $data1Array = [];
        $data2Array = [];
        foreach($matchGroups as $monthYear => $groups) {
//            echo " --\n $monthYear -\n";
            array_push($monthArray, explode('-',$monthYear)[1]);
            $budgetTotal = 0;
            $grandtTotal = 0;
            foreach($groups as $group) {
//                print_r($group->toArray());
                $budgetTotal += $group->budget_total;
                $grandtTotal += $group->grand_total;
            }
            array_push($data1Array, $budgetTotal);
            array_push($data2Array, $grandtTotal);
        }

        return API::response()->array([
            'labels' => $monthArray,
            'data' => [$data2Array, $data1Array]
        ])->statusCode(200);

    }

    public function calendar()
    {
        $project = [];$data = []; $i = 0;
        $customers = auth()->user()->customers;
        foreach($customers as $customer) {

            foreach($customer->projects as $project) {
                if($project->status == 1) {
                    $start = $project->projectMilestones->min('start_date');
                    $end = $project->projectMilestones->max('end_date');
                    if($start && $end) {
                        $classArr = ['event-red', 'event-blue', 'event-blue-dark', 'event-orange', 'event-green'];
                        $class = $i <= 4 ? $classArr[$i] : $classArr[$i=0];
                        $data[] = ['title' => $project->slug,
                            'start' => $start,
                            'end' => $end,
                            'cssClass' => [$class]
                        ];
                        $i++;
                    }
                }
            }

        }

        return API::response()->array($data)->statusCode(200);

    }

}
