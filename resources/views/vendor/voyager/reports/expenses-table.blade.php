<table class="table table-responsive table-bordered" cellspacing="0" cellpadding="0" width="100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>Expense Number</th>
        <th>Date</th>
        <th>Expense Month</th>
        <th>Vendor Name</th>
        <th>Item Description</th>
        <th>Quantity</th>
        <th>Rate</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($expenses as $key => $expense)
        <tr>
            <td>{{ $expense->id }}</td>
            <td>{{ $expense->expense_number }}</td>
            <td>{{ $expense->date }}</td>
            <td>{{ $expense->expense_month }}</td>
            <td>{{ $expense->vendor_name }}</td>
            <td>{{ $expense->item_description }}</td>
            <td>{{ $expense->quantity }}</td>
            <td>{{ $expense->rate }}</td>
            <td>Rs. {{ $expense->amount }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="8" style="text-align: center"><span style="font-weight: bold">Total Amount</span></td>
        <td><span style="font-weight: bold">Rs. {{ number_format($total, 2) }}</span></td>
    </tr>

    </tbody>
</table>
