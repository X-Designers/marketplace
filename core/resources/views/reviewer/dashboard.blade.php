@extends('reviewer.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-sm-4 mb-30">
            <div class="dashboard-w1 bg--primary b-radius--10 box-shadow">
                <a href="" class="item--link"></a>
                <div class="icon">
                    <i class="lab la-product-hunt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$totalPending}}</span>
                        <span class="currency-sign"></span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Pending Products')</span>
                    </div>
                    <a href="{{route('reviewer.product.pending')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-4 mb-30">
            <div class="dashboard-w1 bg--cyan b-radius--10 box-shadow">
                <a href="" class="item--link"></a>
                <div class="icon">
                    <i class="lab la-product-hunt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$totalApproved}}</span>
                        <span class="currency-sign"></span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Approved Products')</span>
                    </div>
                    <a href="{{route('reviewer.product.approved')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-4 mb-30">
            <div class="dashboard-w1 bg--gradi-44 b-radius--10 box-shadow">
                <a href="" class="item--link"></a>
                <div class="icon">
                    <i class="lab la-product-hunt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$totalSoft}}</span>
                        <span class="currency-sign"></span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Soft Rejected Products')</span>
                    </div>
                    <a href="{{route('reviewer.product.softrejected')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-4 mb-30">
            <div class="dashboard-w1 bg--gradi-7 b-radius--10 box-shadow">
                <a href="" class="item--link"></a>
                <div class="icon">
                    <i class="lab la-product-hunt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$totalHard}}</span>
                        <span class="currency-sign"></span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Hard Rejected Products')</span>
                    </div>
                    <a href="{{route('reviewer.product.hardrejected')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-4 mb-30">
            <div class="dashboard-w1 bg--orange b-radius--10 box-shadow ">
                <a href="" class="item--link"></a>
                <div class="icon">
                    <i class="lab la-product-hunt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$totalUpdatePending}}</span>
                        <span class="currency-sign"></span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Update Pending Products')</span>
                    </div>
                    <a href="{{route('reviewer.product.update.pending')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-4 mb-30">
            <div class="dashboard-w1 bg--pink b-radius--10 box-shadow">
                <a href="" class="item--link"></a>
                <div class="icon">
                    <i class="lab la-product-hunt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$totalResubmitted}}</span>
                        <span class="currency-sign"></span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Resubmitted Products')</span>
                    </div>
                    <a href="{{route('reviewer.product.resubmit')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
    </div>

@endsection
