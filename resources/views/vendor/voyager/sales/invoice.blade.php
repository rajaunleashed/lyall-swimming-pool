@extends('voyager::master')

@section('page_title', __('messages.invoice'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ __('messages.invoice') }}

        @can('edit', $dataTypeContent)
            <a href="{{ route('voyager.'.$dataType->slug.'.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
                <span class="glyphicon glyphicon-pencil"></span>&nbsp;
                {{ __('voyager::generic.edit') }}
            </a>
        @endcan
        @can('delete', $dataTypeContent)
            @if($isSoftDeleted)
                <a href="{{ route('voyager.'.$dataType->slug.'.restore', $dataTypeContent->getKey()) }}"
                   title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore"
                   data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span
                        class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
                </a>
            @else
                <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete"
                   data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span
                        class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
                </a>
            @endif
        @endcan
        @can('browse', $dataTypeContent)
            <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
                <span class="glyphicon glyphicon-list"></span>&nbsp;
                {{ __('voyager::generic.return_to_list') }}
            </a>
        @endcan
        @can('browse', $dataTypeContent)
            <a href="#" onclick="printInvoice('{{ route('sales.invoice.print', ['id' => $sale->id]) }}')" class="btn btn-warning print">
                <span class="glyphicon glyphicon-print"></span>&nbsp;
                {{ __('Print') }}
            </a>
        @endcan
        @can('browse', $dataTypeContent)
            <a href="{{ route('sales.invoice.download', ['id' => $sale->id]) }}" class="btn btn-danger">
                <span class="glyphicon glyphicon-file"></span>&nbsp;
                {{ __('Download PDF') }}
            </a>
        @endcan
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content read container-fluid">
        <form action="{{ route('sales.invoice') }}" method="post">
            @csrf
            <input type="hidden" value="{{ $sale->id }}" name="id">
            <div class="row">
                <div class="col-md-8 col-md-offset-2" id="invoice" style="background: white">
                    <div class="row mt-3">
                        <div class="col-md-12" id="col_1">
                            <div class="form-group">
                                <label for="invoiceNumber" class="control-label col-lg-2 col-sm-4"><b>Invoice
                                        #</b></label>
                                <div class="col-lg-8 col-sm-8">
                                    <h4 style="margin-top: 0">
                                        <span>{{ $sale->id }}</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" id="col_1">
                            <div class="form-group">
                                <label for="customer" class="control-label col-lg-4 col-sm-4"><b>Customer</b></label>
                                <div class="col-lg-8 col-sm-8">
                                    <h4 style="margin-top: 0; margin-bottom: 0;">
                                        <span>{{ $sale->customer_name }}</span>
                                    </h4>
                                    <a style="font-size:12px"
                                       href="{{ route('voyager.customers.show', ['id' => $sale->customer_id]) }}"
                                       target="_blank">View Customer</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" id="col_1">
                            <div class="form-group">
                                <label for="invoice_date" class="control-label col-lg-4 col-sm-4"><b>Invoice
                                        Date</b></label>
                                <div class="col-lg-8 col-sm-8">
                                    <div class="input-group">
                                        <input class="form-control" data-date-format="dd-mm-yyyy" id="invoice_date"
                                               type="date" name="created_at"
                                               value="{{ \Carbon\Carbon::parse($sale->created_at)->toDateString() }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <table class="table table-responsive table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Discount</th>
                                    <th>Total Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sale->saleProducts as $product)
                                    <tr>
                                        <td>{{ $product->product->name }}</td>
                                        <td>{{ Helper::formatCurrency($product->price) }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->discount }}</td>
                                        <td>{{ Helper::formatCurrency($product->total_price) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <td>{{ Helper::formatCurrency($sale->saleProducts->sum('total_price')) }}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Comments</label>
                            <textarea class="form-control" rows="5" name="comments">{{ $sale->comments }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection

@section('javascript')
    @parent
    <script>
        function printInvoice(url) {
            var printWindow = window.open( url, 'Print', 'left=200, top=200, width=750, height=600, toolbar=0, resizable=0');
            printWindow.addEventListener('load', function(){
                printWindow.print();
                // printWindow.close();
            }, true);
        }
    </script>
@endsection
