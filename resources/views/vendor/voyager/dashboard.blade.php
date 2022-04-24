@extends('voyager::master')

@section('content')
    <div class="page-content container">
        <div class="row" style="margin-top: 20px">
            <div class='col-sm-3'>
            </div>
            <form action="/admin/" method="GET">
                <div class='col-sm-3'>
                    <span>START DATE</span>
                    <input type="date" value="{{ request()->get('start_date') }}" class="form-control"
                           name="start_date">
                </div>

                <div class='col-sm-3'>
                    <span>END DATE</span>
                    <input type="date" value="{{ request()->get('end_date') }}" class="form-control" name="end_date">
                </div>

                <div class='col-sm-3'>
                    <button class="btn btn-primary" style="margin-top: 25px;">show</button>
                </div>
            </form>
        </div>

        <div class="row" style="margin-top: 20px">
            <div class="col-12 col-lg-4">
                <div class="card radius-10">
                    <div class="card-body bg-primary">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="text-uppercase">Daily Sales</h5>
                                <h4 class="font-weight-bold mb-0">Rs. {{$sales}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card radius-10">
                    <div class="card-body" style="background-color: #D53343; color: white">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="text-uppercase">No. of Person</h5>
                                <h4 class="font-weight-bold mb-0">{{$no_of_persons}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card radius-10">
                    <div class="card-body" style="background-color: #27A243; color: white">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="text-uppercase">No. of Locker</h5>
                                <h4 class="font-weight-bold mb-0">{{$no_of_lockers}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{--        1st row end--}}


        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card radius-10">
                    <div class="card-body" style="background-color: #D53343; color: white">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="text-uppercase">No. of Booking </h5>
                                <h4 class="font-weight-bold mb-0">{{$no_of_bookings ?? 0}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card radius-10">
                    <div class="card-body" style="background-color: #32383E; color: white">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="text-uppercase">Expenses </h5>
                                <h4 class="font-weight-bold mb-0">Rs. {{$expenses ?? '0'}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
