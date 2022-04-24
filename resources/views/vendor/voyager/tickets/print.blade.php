<html>
<head>
    <title>Ticket # {{ $ticket->id }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
	/* style sheet for "A4" printing */
		@page {
			size: 80mm 120mm;
		}
		@media print 
		{
			@page {
			  size: size: 80mm 120mm;
			  margin:0;
			}
		}
        body {
            font-family: Calibri, sans-serif;
			margin: 0mm 0mm 116mm 0mm;
			
        }
        #main-wrapper {
            width: 500px;
            margin: 10px auto;
            padding: 20px;
            border: 1px solid #c9c5c5;
            padding-bottom: 10px;
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
            width: 100%;
			font-size: 30px
        }

        .heading .logo {
            float: right;
            width: 50%
        }
        p {
            font-size:14px;
            padding: 0;
            margin:0;
        }
    </style>
</head>
<body>
<div id="main-wrapper">
<div class="heading" >
    <div class="intro">
        <h3 style="padding:0;margin:0;">{{ setting('admin.title') }}</h3>
        <h5 style="padding:0;margin:0;font-weight:normal; font-size: 16px">{{setting('admin.address')}}</h5>
        <h5 style="padding:0;margin:0;font-weight:normal; font-size: 16px">Mobile # {{setting('admin.contact_number')}}</h5>
    </div>
   
</div>
<div style="clear:both"></div>
<hr />
<h5 style="margin: 20px 0 5px">Ticket # {{ $ticket->id }}</h5>
<h3 style="margin: 0 0 10px 0;">No. of {{ $ticket->type }}: <br /><span style="font-size: 80px">{{ $ticket->number_of_person }}</span></h3>
<p><strong>Customer:</strong> {{ $ticket->customer_name }}</p>

<br />
<p>Creation Date: {{ \Carbon\Carbon::parse($ticket->date)->format('d/m/Y h:m:i') }}</p>
<p>Printing Date: {{ now()->format('d/m/Y h:m:i') }}</p>

</div>
<p style="margin: 0 0 0 20px; font-size: 14px">Powered by: softronicsol.com, +92 333 652 70 45</p>
</body>
</html>
