@extends('voyager::master')

@section('page_title')
    {{ __('messages.stock_sale_report')  }}
@endsection

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-file-text"></i> {{ __('messages.stock_sale_report') }}
    </h1>
    <a href="#" onclick="printInvoice('{{ route('report.stock.sale', ['month' => $month]) }}')" class="btn btn-warning print">
        <span class="glyphicon glyphicon-print"></span>&nbsp;
        {{ __('Print') }}
    </a>
@stop

@section('extra_actions')
    <div class="page-content  browse container-fluid">
        <div class="row">
            <div class="col-md-3" style="margin-bottom: 0">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <label for="month">Month:</label>
                        <select class="form-control custom-select select2 select2-container" id="month">
                            @foreach($months as $month)
                                <option value="{{ $month }}" @if(request()->segment(4) == $month) selected @endif>{{ \Carbon\Carbon::parse($month)->isoFormat('MMMM Y') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">Month: {{ \Carbon\Carbon::parse($month)->isoFormat('MMMM Y') }}</h3>
                    </div>
                    <div class="panel-body" style="padding-top:0;">
                        @include('vendor.voyager.reports.stock-sale-table', [
                            'stock' => $stock
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    @parent
    <script>
        $('#month').on('change', function() {
            const month = $(this).val();
            if (month) {
                window.location.href = '/admin/reports/stock-sale/' + month;
            }
        });
    </script>
@endsection
