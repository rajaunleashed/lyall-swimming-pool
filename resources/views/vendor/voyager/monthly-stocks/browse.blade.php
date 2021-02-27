@extends('vendor.voyager.bread.browse')

@if(count($months))
    @section('extra_actions')
        <div class="page-content  browse container-fluid">
            <div class="row">
                <div class="col-md-3" style="margin-bottom: 0">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <label for="month">Month:</label>
                            <select class="form-control custom-select select2 select2-container" id="month">
                                @foreach($months as $month)
                                    <option value="{{ $month }}" @if(request()->get('month') == $month) selected @endif>{{ \Carbon\Carbon::parse($month)->isoFormat('MMMM Y') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endif

@section('javascript')
    @parent
    <script>
        $('#month').on('change', function() {
           const month = $(this).val();
           if (month) {
               window.location.href = '/admin/monthly-stocks?month=' + month;
           }
        });
    </script>
@endsection
