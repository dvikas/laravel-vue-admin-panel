<?php

namespace App\Mail;

use App\Entities\Project;
use App\Entities\ProjectMilestone;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Barryvdh\DomPDF\Facade as PDF;

class ProjectInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $project;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        $projectObj = Project::where('uuid', '7dea82c0-479e-11e8-812b-436f436e2a23')->firstOrFail();
//        $userObj = User::where('uuid', '2553f7a0-0ccf-11e8-bff9-d1e8efd10d99')->firstOrFail();
        $projectObj = $this->project;
        $userObj = auth()->user();
        $taskSubTasks = ProjectMilestone::getCustomerTasks($this->project->id, auth()->user()->id);
        $pdf = PDF::loadView('invoice', compact('taskSubTasks','projectObj', 'userObj'));

        $address = 'phpcubes@gmail.com';
        $name = 'All renos support';
        $subject = 'All Reno project invoice #'.$this->project->id;
        $fileName = 'invoice_'.date('m-d-Y');
        return $this->markdown('emails.project-invoice')
            ->attachData($pdf->output(), "{$fileName}.pdf")
            ->from($address, $name)
//            ->cc($address, $name)
//            ->bcc($address, $name)
            ->replyTo('support@allrenos.com', $name)
            ->subject($subject);
    }
}
