@extends('voyager::master')

@section('page_title')
    {{ __('Daily Sales')  }}
@endsection

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-file-text"></i> {{ __('Daily Sales') }}
    </h1>
@stop

@section('extra_actions')
    <div class="page-content  browse container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <form>
                            <div class="row">
                                <div class="col-md-3">

                                    <label for="month">Date:</label>
                                    <input type="date" name="date" id="date" class="form-control" />
                                </div>

                                <div class="col-md-3">
                                    <button style="margin-top: 27px" type="reset" name="filter"
                                            class="btn btn-primary">Reset
                                    </button>
                                    <button style="margin-top: 27px" type="submit" name="filter"
                                            class="btn btn-primary">Search
                                    </button>
                                </div>
                            </div>
                        </form>
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
                    @if(request()->has('date'))
                        <div class="panel-heading" style="border-bottom:0;">
                            <a onclick="printExpense('{{ route('reports.sales', ['date' => request()->get('date')]) }}')" href="#" style="float: right; margin: 10px 20px" class="btn btn-warning"><i class="voyager-documentation">Print</i></a>

                            <h3 class="panel-title">
                                Date: {{ request()->get('date')}}</h3>
                        </div>
                    @endif
                    <div class="panel-body" style="padding-top:0;">
                        @include('vendor.voyager.reports.sales.sales-table', [
                            'sales' => $sales
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

    </script>
@endsection
