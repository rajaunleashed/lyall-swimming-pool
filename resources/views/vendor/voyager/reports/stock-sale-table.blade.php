<table class="table table-responsive table-bordered" cellspacing="0" cellpadding="0">
    <thead>
    <tr>
        <th colspan="7">&nbsp;</th>
        <th colspan="3"><span style="font-weight: bold">Net sale & amount</span></th>
        <th colspan="4"><span style="font-weight: bold">Closing Stock</span></th>
    </tr>
    <tr>
        <th>P#</th>
        <th>Product Name</th>
        <th>Trade Price</th>
        <th>Opening Stock</th>
        <th>Stock In</th>
        <th>Stock Out</th>
        <th>Total Quantity</th>
        <th>Quantity</th>
        <th>Bonus</th>
        <th>Amount</th>
        <th>Fresh</th>
        <th>Expired</th>
        <th>Total</th>
        <th>Amount</th>
        {{--                                <th>Quantity</th>--}}
        {{--                                <th>Dev %</th>--}}
    </tr>
    </thead>
    <tbody>
    @foreach($stock as $key => $item)
        <tr>
            <td colspan="15" style="font-weight: bold">Group: {{ $key }} GROUP</td>
        </tr>
        @php
            $groupNetTotal = [
                'total_quantity' => $stock[$key]->sum('opening_stock') + $stock[$key]->sum('stock_in'),
                'total_sale_amount' => $stock[$key]->sum('sale_amount'),
                'closing_stock_amount' => 0
            ];
        @endphp
        @foreach($stock[$key] as $groupItem)
            <tr>
                <td>{{ $groupItem->item_id }}</td>
                <td>{{ $groupItem->name }}</td>
                <td>{{ $groupItem->trade_price }}</td>
                <td>{{ $groupItem->opening_stock }}</td>
                <td>{{ $groupItem->stock_in }}</td>
                <td>{{ $groupItem->stock_out }}</td>
                <td>{{ $groupItem->opening_stock + $groupItem->stock_in }}</td>
                <td>{{ $groupItem->stock_out }}</td>
                <td>{{ $groupItem->bonus }}</td>
                <td>{{ $groupItem->sale_amount }}</td>
                <td>{{ $groupItem->stock_quantity - $groupItem->bonus - $groupItem->expired }}</td>
                <td>{{ $groupItem->expired }}</td>
                <td>{{ ($groupItem->stock_quantity - $groupItem->bonus - $groupItem->expired) + $groupItem->expired }}</td>
                <td>
                    @php
                        $closingStockAmount = (($groupItem->stock_quantity - $groupItem->bonus - $groupItem->expired) + $groupItem->expired) * $groupItem->trade_price;
                        $groupNetTotal['closing_stock_amount'] = $groupNetTotal['closing_stock_amount'] + $closingStockAmount;
                    @endphp
                    {{ $closingStockAmount }}
                </td>
                {{--                                    <td>{{ $item->expired }}</td>--}}
                {{--                                    <td>{{ $item->expired }}</td>--}}
            </tr>
        @endforeach
        <tr>
            <td colspan="6"><span style="font-weight: bold">Group Total:</span></td>
            <td><span style="font-weight: bold">{{ $groupNetTotal['total_quantity'] }}</span></td>
            <td colspan="2"></td>
            <td><span style="font-weight: bold">{{ $groupNetTotal['total_sale_amount'] }}</span></td>
            <td colspan="3"></td>
            <td><span style="font-weight: bold">{{ $groupNetTotal['closing_stock_amount'] }}</span></td>
        </tr>
    @endforeach
    </tbody>
</table>
