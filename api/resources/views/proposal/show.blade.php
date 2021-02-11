@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="container">
            <p>Hello {{ $supplier->name }},</p>

            @if($supplierQuoteDetail->status === 1 )
                <div class="alert alert-success" >
                    Thanks, for submitting your proposal. .
                </div>
            @else
                <p>You are invited to submit a proposal for following.</p>
            @endif

            <div class="row">
                <div class="col-sm-3">
                    <strong>Task</strong> : {{ $supplierProjectTask->supplierUserTask->name }}
                </div>
                <div class="col-sm-3">
                    <strong>Quantity</strong> : {{ $supplierProjectTask->quantity }}
                </div>
                <div class="col-sm-3">
                    <strong>Unit</strong> : {{ $supplierProjectTask->unit }}
                </div>
                <div class="col-sm-3">
                    <strong>Deadline</strong> : {{ $supplierProjectTask->deadline }}
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <strong>Notes</strong> :{{ $supplierQuoteDetail->user_notes }}
                </div>
            </div>
        </div>

        <div class="row">
            @if($supplierQuoteDetail->status === 1 )
                <div class="col-sm-6">
                    <hr>
                    <form  role="form">

                        <div class="col-sm-4 form-group{{ $errors->has('rate') ? ' has-error' : '' }}">
                            <label for="rateId">Rate</label>
                            <div>${{ $supplierQuoteDetail->supplier_rate }}</div>
                        </div>

                        <div class="col-sm-4 form-group{{ $errors->has('total') ? ' has-error' : '' }}">
                            <label for="totalId">Total</label>
                            <div>${{ $supplierQuoteDetail->supplier_total }}</div>
                        </div>

                        <div class=" col-sm-12 form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                            <label for="slugId">Message</label>
                            <div >{{ $supplierQuoteDetail->supplier_notes }}</div>
                        </div>
                        <div class="col-sm-12 text-success">
                                Proposal submitted on: <strong>{{ date('m-d-Y', strtotime($supplierQuoteDetail->sent_at)) }}</strong>

                        </div>


                    </form>
                </div>

            @else
                <div class="col-sm-6">
                    <hr>
                    <form action="/proposal/{{ $supplierProjectTask->uuid }}/{{ $supplier->uuid }}" method="post" role="form">
                        {{ csrf_field() }}

                        <div class="col-sm-4 form-group{{ $errors->has('rate') ? ' has-error' : '' }}">
                            <label for="rateId">Rate</label>
                            <input type="number" class="form-control " maxlength="8"
                                   required name="rate" id="rateId" placeholder="Rate">
                            @if ($errors->has('rate'))
                                <span class="help-block"><strong>{{ $errors->first('rate') }}</strong></span>
                            @endif
                        </div>

                        <div class="col-sm-4 form-group{{ $errors->has('total') ? ' has-error' : '' }}">
                            <label for="totalId">Total</label>
                            <input type="number" class="form-control " maxlength="8"
                                   name="total" id="totalId" placeholder="Total" required >
                            @if ($errors->has('total'))
                                <span class="help-block"><strong>{{ $errors->first('total') }}</strong></span>
                            @endif
                        </div>

                        <div class=" col-sm-12 form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                            <label for="slugId">Message</label>
                            <textarea class="form-control " name="message" id="messageId" required
                                      maxlength="200" placeholder="Message"></textarea>
                            @if ($errors->has('slug'))
                                <span class="help-block"><strong>{{ $errors->first('message') }}</strong></span>
                            @endif
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection