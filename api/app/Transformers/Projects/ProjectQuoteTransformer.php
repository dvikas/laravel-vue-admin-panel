<?php

namespace App\Transformers\Projects;

use App\Entities\ProjectQuote;
use League\Fractal\TransformerAbstract;

class ProjectQuoteTransformer extends TransformerAbstract
{
    /**
     * @param ProjectQuote $model
     * @return array
     */
    public function transform(ProjectQuote $model)
    {
        return [
            'id' => $model->uuid,
            'email_received' => $model->email_received,
            'amount_received' => $model->amount_received,
            'payment_details' => $model->payment_details,
            'document' => $model->document,
            'accepted_date' =>  $model->created_at->format('m-d-Y'),

        ];
    }

}
