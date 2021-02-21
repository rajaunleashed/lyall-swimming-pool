@extends('vendor.voyager.bread.edit-add')

@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@section('content')
    <div class="page-content edit-add container-fluid" id="app">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                        <div class="panel-body">
                            <sales-component :id="{{$edit ? $dataTypeContent->getKey() : 0 }}"></sales-component>
                        </div><!-- panel-body -->

                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop


@section('javascript')
    @parent
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

    <script>
        $.noConflict();
    </script>
@endsection
