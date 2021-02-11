<?php

namespace App\Mail;

use App\Entities\Supplier;
use App\Entities\SupplierProjectTask;
use App\Entities\SupplierQuoteDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SupplierSubmittedProposal extends Mailable
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
        $subject = 'Proposal submitted from supplier';
        return $this->markdown('emails.supplier-submitted-proposal')
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject);
    }
}
