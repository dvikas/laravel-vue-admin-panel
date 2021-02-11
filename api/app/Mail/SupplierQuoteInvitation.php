<?php

namespace App\Mail;

use App\Entities\Project;
use App\Entities\ProjectMilestone;
use App\Entities\Supplier;
use App\Entities\SupplierProjectTask;
use App\Entities\SupplierQuoteDetail;
use App\Entities\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Barryvdh\DomPDF\Facade as PDF;

class SupplierQuoteInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $supplier;
    public $supplierQuoteDetail;
    public $supplierProjectTask;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Supplier $supplier,
                                SupplierQuoteDetail $supplierQuoteDetail,
                                SupplierProjectTask $supplierProjectTaskObj)
    {
        $this->supplier = $supplier;
        $this->supplierQuoteDetail = $supplierQuoteDetail;
        $this->supplierProjectTask = $supplierProjectTaskObj;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $address = 'support@allrenos.com';
        $name = 'All Renos support';
        $subject = 'You are invited to submit Proposal on All Renos';
        return $this->markdown('emails.supplier-quote-invitation')
            ->from($address, $name)
//            ->cc($address, $name)
//            ->bcc($address, $name)
            ->replyTo($address, $name)
            ->subject($subject);
    }
}
