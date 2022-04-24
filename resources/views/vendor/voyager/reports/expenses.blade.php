@extends('voyager::master')

@section('page_title')
    {{ __('messages.expenses')  }}
@endsection

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-file-text"></i> {{ __('messages.expenses') }}
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

                                    <label for="month">Month:</label>
                                    <select name="month" class="form-control custom-select select2 select2-container"
                                            id="month">
                                        @foreach($months as $month)
                                            <option value="{{ $month }}"
                                                    @if(request()->get('month') == $month) selected @endif>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="month">Year:</label>
                                    <select name="year" class="form-control custom-select select2 select2-container"
                                            id="month">
                                        @foreach($years as $year)
                                            <option value="{{ $year }}"
                                                    @if(request()->get('year') == $year) selected @endif>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
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
                    @if(request()->has('month') && request()->has('year'))
                        <div class="panel-heading" style="border-bottom:0;">
                            <a onclick="printExpense('{{ route('reports.expenses', ['month' => request()->get('month'), 'year' => request()->get('year')]) }}')" href="#" style="float: right; margin: 10px 20px" class="btn btn-warning"><i class="voyager-documentation">Print</i></a>

                            <h3 class="panel-title">
                                Month: {{ request()->get('month') . '-' . request()->get('year') }}</h3>
                        </div>
                    @endif
                    <div class="panel-body" style="padding-top:0;">
                        @include('vendor.voyager.reports.expenses-table', [
                            'expenses' => $expenses
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
