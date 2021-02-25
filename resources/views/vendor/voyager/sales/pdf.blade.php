<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: Calibri, sans-serif;
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


    </style>
</head>
<body>
@if(setting('admin.logo'))
    @php
        $link = json_decode(setting('admin.logo'));
    @endphp
    <div style="width: 100px; margin: 0 auto;">
        <img style="width: 100%" src="{{ public_path('storage/' . $link[0]->download_link) }}" />
    </div>
@endif
<h1 style="text-align: center;font-size:50px;margin-top: 0; margin-bottom:0;padding-bottom:0">{{ setting('admin.title') }}</h1>
<p style="text-align: center;margin-bottom:0;padding-bottom:0">Address: {{ setting('admin.address') }}</p>
<p style="text-align: center;margin-bottom:0;padding-bottom:0">Contact #: {{ setting('admin.contact_number') }}</p>
<table style="width:100%">

    <tr>
        <td colspan="3"><b>Invoice #</b> {{ $invoice->id }}</td>
        <td style="text-align: right">
            <b>Dated:</b> {{ \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y') }}
        </td>
    </tr>

    <tr>
        <td colspan="4"><b>Customer</b>: {{ $invoice->customer_name }}</td>
    </tr>
    <tr>
        <td colspan="4"><b>Address:</b> <br>
            {{ $invoice->customer->address }}
        </td>
    </tr>
    @if($invoice->customer->mobile_no)
        <tr>
            <td colspan="4"><b>Mobile #:</b> {{ $invoice->customer->mobile_no }}</td>
        </tr>
    @endif

    <tr>
        <td colspan="4" style="padding-top: 30px"></td>
    </tr>

    <tr>
        <td colspan="4"><b>Paid Status</b>:
            <span class="badge badge-danger">
            {{ $invoice->paid_status ? 'Paid' : 'Unpaid' }}</span>
        </td>
    </tr>

    <tr>
        <td colspan="4" style="padding-top: 5px"><b>Descriptions</b></td>
    </tr>
    <tr>
        <td colspan="4">
            <table class="item-table" style="width: 100%" cellspacing="0" >
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Discount</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoice->saleProducts as $product)
                    <tr>
                        <td class="content-center">{{ $product->product->name }}</td>
                        <td class="content-center">{{ Helper::formatCurrency($product->price) }}</td>
                        <td class="content-center">{{ $product->quantity }}</td>
                        <td class="content-center">{{ $product->discount }}</td>
                        <td class="content-center">{{ Helper::formatCurrency($product->total_price) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="4">Total</th>
                    <td  class="content-center">{{ Helper::formatCurrency($invoice->saleProducts->sum('total_price')) }}</td>
                </tr>
                </tfoot>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding-top:50px"></td>
    </tr>
    @if($invoice->comments)
        <tr>
            <td colspan="4">Comments: <br>
                {{ $invoice->comments }}
            </td>
        </tr>
    @endif
</table>
</body>
</html>
