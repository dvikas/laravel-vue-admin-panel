<?php

namespace App\Http\Controllers;

use App\Entities\Project;
use App\Entities\ProjectMilestone;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * /invoice/36b8f0c0-15f6-11e8-96d2-1f3fc52badec/2553f7a0-0ccf-11e8-bff9-d1e8efd10d99
     * https://stackoverflow.com/questions/40847992/how-to-attach-a-pdf-using-barryvdh-laravel-dompdf-into-an-email-in-laravel
     * @param $uuid
     * @param $userUuid
     * @return mixed
     */
    public function invoice($uuid, $userUuid)
    {
        $projectObj = Project::where('uuid', $uuid)->firstOrFail();
        $userObj = User::where('uuid', $userUuid)->firstOrFail();
        $taskSubTasks = ProjectMilestone::getCustomerTasks($projectObj->id, $userObj->id);
//        return view('invoice',compact('taskSubTasks','projectObj', 'userObj'));
        $pdf = PDF::loadView('invoice', compact('taskSubTasks','projectObj', 'userObj'));
//        $message->attachData($pdf->output(), 'filename.pdf');
        return $pdf->download('invoice'.uniqid().'.pdf');
    }


    public function apiSettings()
    {
        return view('home.api-settings');
    }
}
