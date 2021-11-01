@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="pb-100">
    @include($activeTemplate.'partials.dashboardHeader')

    <div class="dashboard-area pt-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-end">
                        <a class="btn btn-sm btn--base" href="{{route('ticket.open')}}">
                            <i class="las la-plus-circle fs-6"></i> @lang('Create Ticket')
                        </a>
                    </div>
                    <div class="table-responsive--md mt-4">

                        <table class="table custom--table">
                            <thead>
                                <tr>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Last Reply')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supports as $key => $support)
                                    <tr>
                                        <td data-label="@lang('Subject')">
                                            <a href="{{ route('ticket.view', $support->ticket) }}" class="text--base"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a>
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if($support->status == 0)
                                                <span class="badge badge--success py-2 px-3">@lang('Open')</span>
                                            @elseif($support->status == 1)
                                                <span class="badge badge--primary py-2 px-3">@lang('Answered')</span>
                                            @elseif($support->status == 2)
                                                <span class="badge badge--warning py-2 px-3">@lang('Customer Reply')</span>
                                            @elseif($support->status == 3)
                                                <span class="badge badge--danger py-2 px-3">@lang('Closed')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>
                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('ticket.view', $support->ticket) }}" class="icon-btn bg--primary"><i class="las la-desktop"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="pagination--sm justify-content-end">
                            {{$supports->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
