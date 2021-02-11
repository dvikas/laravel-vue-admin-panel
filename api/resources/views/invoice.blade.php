<html>
<head>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        body {
            font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #333;
            font-weight: 400;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
            background-color: transparent;
            border-spacing: 0;
            border-collapse: collapse;
        }
        .table > thead > tr > th {
            border-bottom: 2px solid #f4f4f4;
        }
        .table-striped > tbody > tr:nth-of-type(2n+1) {
            background-color: #f9f9f9;
        }
        .invoice {
            position: relative;
            background: #fff;
            border: 1px solid #f4f4f4;
            padding: 20px;
            margin: 10px 25px;
        }
        .row {
            margin-right: -15px;
            margin-left: -15px;
        }
        .table > caption + thead > tr:first-child > td, .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table > thead:first-child > tr:first-child > th {
            border-top: 0;
        }
        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }
        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
            border-top: 1px solid #f4f4f4;
        }
    </style>
</head>
<body>
<div class="invoice">
    <table width="100%">
        <tr>
            <td width="70%"><strong>Invoice</strong> #{{$projectObj->id}}</td>
            <td><strong>Date:</strong> {{ $projectObj->created_at->format('m-d-Y') }}</td>
        </tr>
    </table>

    <table width="100%">
        <tr >
            <td width="70%">
                <div class="invoice-col">
                    From
                    <address>
                        <strong>{{ $userObj['name'] }}</strong><br>
                        {{ $userObj['address'] }}
                        Phone: {{ $userObj['phone'] }}<br>
                        Email: {{ $userObj['email'] }}
                    </address>
                </div>
            </td>
            <td >
                <div class="invoice-col">
                    To
                    <address>
                        <strong>{{ $projectObj->customer['name'] }}</strong><br>
                        {{ $projectObj->customer['address'] }} <br>
                        {{ $projectObj->customer['postal_code'] }} <br>
                        Phone: {{ $projectObj->customer['phone'] }}<br>
                        Email: {{ $projectObj->customer['email'] }}
                    </address>
                </div>
            </td>
        </tr>

        {{--<tr>--}}
            {{--<td>&nbsp;</td>--}}
            {{--<td ><b>Payment Due:</b> 2/22/2014</td>--}}
        {{--</tr>--}}
    </table>

<?php $total = 0 ?>
<!-- Table row -->
    @foreach($taskSubTasks as $taskSubTask)
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Task</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Milestone</th>
                        <th>Amount</th>
                    </tr>
                    <tr style="color:#f71752">
                        <td>{{ $taskSubTask['parent'] }}</td>
                        <td><?=date('m-d-Y', strtotime($taskSubTask['start_date']))?></td>
                        <td><?=date('m-d-Y', strtotime($taskSubTask['end_date']))?></td>
                        <td>{{ $taskSubTask['milestone'] }}</td>
                        <td>{{ $taskSubTask['amount'] }}</td>
                    </tr>
                    <tr>
                        <th>Subtask</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Rate</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($taskSubTask['child'] as $subTask)
                        <tr>
                            <td>{{ $subTask['sub_task'] }}</td>
                            <td>{{ $subTask['quantity'] }}</td>
                            <td>{{ $subTask['unit'] }}</td>
                            <td>{{ $subTask['rate'] }}</td>
                            <td>${{ $subTask['total'] }}</td>
                        </tr>
                        <?php $total += $subTask['total'] ?>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
@endforeach

<!-- /.col -->
    <div class="row">
        <div style="text-align: right;margin-right: 50px;"><strong>Total:</strong> ${{ $total }}</div>
    </div>
    <!-- /.col -->
</div>
</body>
</html>

