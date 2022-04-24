<table class="table table-responsive table-bordered" cellspacing="0" cellpadding="0" width="100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Type</th>
        <th>Quantity</th>
        <th>Rate</th>
        <th>Amount</th>
        <th>Creation Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($sales as $key => $sale)
        <tr>
            <td>{{ $sale->id }}</td>
            <td>{{ $sale->customer_name }}</td>
            <td>{{ $sale->type }}</td>
            <td>{{ $sale->number_of_person }}</td>
            <td>Rs. {{ $sale->rate }}</td>
            <td>Rs. {{ $sale->amount }}</td>
            <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y h:m:i') }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="5" style="text-align: center"><span style="font-weight: bold">Total Amount</span></td>
        <td colspan="2"><span style="font-weight: bold">Rs. {{ number_format($total, 2) }}</span></td>
    </tr>

    </tbody>
</table>
