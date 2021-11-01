@extends('admin.layouts.app')

@section('panel')

    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Date')</th>
                                    <th scope="col">@lang('Code')</th>
                                    <th scope="col">@lang('Product')</th>
                                    <th scope="col">@lang('Author')</th>
                                    <th scope="col">@lang('Buyer')</th>
                                    <th scope="col">@lang('Licence')</th>
                                    <th scope="col">@lang('Support')</th>
                                    <th scope="col">@lang('Price')</th>
                                    <th scope="col">@lang('Support Fee')</th>
                                    <th scope="col">@lang('Amount')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($sells as $item)
                                    <tr>
                                        <td data-label="@lang('Date')">{{ showDateTime($item->created_at,'d-m-Y') }}</td>
                                        <td data-label="@lang('Code')">{{ $item->code }}</td>
                                        <td data-label="@lang('Product')">{{ $item->product->name }}</td>
                                        <td data-label="@lang('Author')">
                                            <a href="{{route('admin.users.detail',$item->author->id)}}">{{ $item->author->username }}</a>
                                        </td>
                                        <td data-label="@lang('Buyer')">
                                            <a href="{{route('admin.users.detail',$item->user->id)}}">{{ $item->user->username }}</a>
                                        </td>
                                        <td data-label="@lang('Licence')">
                                            @if ($item->license == 1)
                                                @lang('Regular')
                                            @elseif ($item->license == 2)
                                                @lang('Extended')
                                            @endif
                                        </td>
                                        <td data-label="@lang('Support')">
                                            @if ($item->support_time)
                                                {{$item->support_time}}
                                            @else
                                                @lang('No support')
                                            @endif
                                        </td>
                                        <td data-label="@lang('Price')">{{$general->cur_sym}}{{getAmount($item->product_price)}}</td>
                                        <td data-label="@lang('Support Fee')">{{$general->cur_sym}}{{getAmount($item->support_fee)}}</td>
                                        <td data-label="@lang('Amount')">{{$general->cur_sym}}{{getAmount($item->total_price)}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $sells->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>

    @push('breadcrumb-plugins')
        <a href="javascript:void(0)" class="btn btn-sm btn--primary box--shadow1 text--small addBtn mb-4"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a><br>
        @if(request()->routeIs('admin.sell.log'))
            <form action="{{ route('admin.sell.log.search') }}" method="GET" class="form-inline float-sm-right bg--white">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('Purchase Code')" value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        @else
            <form action="{{ route('admin.sell.log.search') }}" method="GET" class="form-inline float-sm-right bg--white">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('Purchase Code')" value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        @endif
    @endpush
@endsection
