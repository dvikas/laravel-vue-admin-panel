@component('mail::message')
Hello {{ $supplier->user->name }},

Supplier ( {{ $supplier->name }} ) submitted proposal for following.

**Task :** {{ $supplierProjectTask->supplierUserTask->name }}

**Quantity :** {{ $supplierProjectTask->quantity }}

**Unit :** {{ $supplierProjectTask->unit }}

**Deadline :** {{ date('m-d-Y', strtotime($supplierProjectTask->deadline)) }}

**Admin Notes:** {{ $supplierQuoteDetail->user_notes }}

<hr>

**Supplier rate :** ${{ $supplierQuoteDetail->supplier_rate }}

**Supplier total :** ${{ $supplierQuoteDetail->supplier_total }}

**Supplier Message:** {{ $supplierQuoteDetail->supplier_notes }}

**Submitted on date:** {{ date('m-d-Y', strtotime($supplierQuoteDetail->accepted_at)) }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
