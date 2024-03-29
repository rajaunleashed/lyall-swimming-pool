<html>
<head>
    <title>Expenses Report</title>
    <style>
        body {
            font-family: Calibri, sans-serif;
        }

        table {
            font-size: 10px;
            border: 1px solid #000;
            border-collapse: collapse;
        }

        table tr th, table tr td {
            border: 1px solid #000;
            padding: 2px;
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
        .item-table tr th {
            padding: 10px;
            border: 1px solid #dedada;
        }

        .item-table tr td,
        .item-table tr th {
            padding: 10px;
        }

        .item-table tfoot tr th,
        .item-table tfoot tr td {
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
            font-size: 10px;
            padding: 0;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="heading">
    <div class="intro">
        <h3 style="padding:0;margin:0;">{{ setting('admin.title') }}</h3>
        <h5 style="padding:0;margin:0;font-weight:normal">Expenses</h5>
        <h5 style="padding:0;margin:0;font-weight:normal">{{setting('admin.address')}}</h5>
        <h5 style="padding:0;margin:0;font-weight:normal">Mobile # {{setting('admin.contact_number')}}</h5>
    </div>
    <div class="logo">
        @if(setting('admin.logo'))
            @php
                $link = json_decode(setting('admin.logo'));
            @endphp
            <div style="width: 100px; margin: 0 auto;float:right">
                <img style="width:100%" src="{{ '/storage/' . $link[0]->download_link }}"/>
            </div>
        @endif
    </div>
</div>
<div style="clear:both"></div>
<hr/>

@if(isset($_GET['month']) && isset($_GET['year']))
    <p>Month: {{ $_GET['month'] }}-{{ $_GET['year'] }}</p>
@endif
<p>Printing Date: {{ now()->format('d/m/Y') }}</p>

<h3 style="text-align:center">Expenses Report</h3>
@include('vendor.voyager.reports.expenses-table', [
    'expenses' => $expenses
])
</body>
</html>
