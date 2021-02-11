@component('mail::message')
Hello {{ $supplier->name }},

You are invited to submit a proposal for following.

**Task :** {{ $supplierProjectTask->supplierUserTask->name }}

**Quantity :** {{ $supplierProjectTask->quantity }}

**Unit :** {{ $supplierProjectTask->unit }}

**Deadline :** {{ date('m-d-Y', strtotime($supplierProjectTask->deadline)) }}


{{ $supplierQuoteDetail->user_notes }}


If you are interested then please click following link to submit proposal.

@component('mail::button', ['url' => env('APP_URL').'/proposal/'.$supplierProjectTask->uuid.'/'.$supplier->uuid])
Submit my proposal
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
