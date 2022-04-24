<html>
<head>
    <title>Ticket # {{ $ticket->id }}</title>
    <style>
        body {
            font-family: Calibri, sans-serif;
        }
        #main-wrapper {
            width: 350px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #c9c5c5;
            padding-bottom: 50px;
        }
        table {
            font-size: 10px;
            border: 1px solid #000;
            border-collapse: collapse;
            width: 100%;
        }
        table tr th, table tr td {
            border: 1px solid #000;
            padding:2px;
            text-align: center !important;
        }
        table tr th {
            text-align: center;

        }
        .item-table {
            padding-top: 20px;
            border: 1px;
        }
        .content-center {
            text-align: center;
        }
        .item-table thead > tr > th {
            padding: 10px;
            background: #eee;

        }
        .item-table tr td,
        .item-table tr th
        {
            padding: 10px;
            border: 1px solid #dedada;
        }

        .item-table tr td,
        .item-table tr th
        {
            padding: 10px;
        }

        .item-table tfoot tr th,
        .item-table tfoot tr td
        {
            background: #f3f3f3
        }
        .heading {
            width: 100%
        }
        .heading .intro {
            float: left;
            width: 50%
        }
        .heading .logo {
            float: right;
            width: 50%
        }
        p {
            font-size:10px;
            padding: 0;
            margin:0;
        }
    </style>
</head>
<body>
<div id="main-wrapper">
<div class="heading">
    <div class="intro">
        <h3 style="padding:0;margin:0;">{{ setting('admin.title') }}</h3>
        <h5 style="padding:0;margin:0;font-weight:normal">{{setting('admin.address')}}</h5>
        <h5 style="padding:0;margin:0;font-weight:normal">Mobile # {{setting('admin.contact_number')}}</h5>
    </div>
    <div class="logo">
        @if(setting('admin.logo'))
            @php
                $link = json_decode(setting('admin.logo'));
            @endphp
            <div style="width: 100px; margin: 0 auto; float:right">
                <img style="width:100%" src="{{ '/storage/' . $link[0]->download_link }}" />
            </div>
        @endif
    </div>
</div>
<div style="clear:both"></div>
<hr />

<p>Date: {{ \Carbon\Carbon::parse($ticket->date)->format('d/m/Y') }}</p>
<p>Printing Date: {{ now()->format('d/m/Y') }}</p>

<h4>Ticket # {{ $ticket->id }}</h4>
    <p><strong>Customer:</strong> {{ $ticket->customer_name }}</p>
<br />
<table class="table table-responsive table-bordered" cellspacing="0" cellpadding="0">
    <thead>
    <tr>
        <th>Sr#</th>
        <th>Number of Person</th>
        <th>Rate</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->number_of_person }}</td>
                <td>{{ $ticket->rate }}</td>
                <td>{{ $ticket->amount }}</td>
        <tr>
    </tbody>
</table>
{{--<p style="margin-top: 20px">This ticket is auto generated.</p>--}}
</div>

</body>
</html>
