@extends($activeTemplate.'layouts.frontend')
    @section('content')

        <div class="pb-100">
            @include($activeTemplate.'partials.dashboardHeader')

            <div class="dashboard-area pt-50">
                <div class="container">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-end">
                                <a class="btn btn-sm btn--base" href="{{route('user.withdraw')}}">
                                    <i class="las la-university fs-6"></i> @lang('Withdraw Now')
                                </a>
                            </div>
                            <div class="table-responsive--md mt-4">

                                <table class="table custom--table">
                                    <thead>
                                        <tr>
                                            <th>@lang('Transaction ID')</th>
                                            <th>@lang('Gateway')</th>
                                            <th>@lang('Amount')</th>
                                            <th>@lang('Charge')</th>
                                            <th>@lang('After Charge')</th>
                                            <th>@lang('Rate')</th>
                                            <th>@lang('Receivable')</th>
                                            <th>@lang('Status')</th>
                                            <th>@lang('Time')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($withdraws as $k=>$data)

                                            <tr>
                                                <td data-label="@lang('Transaction ID')">{{$data->trx}}</td>
                                                <td data-label="@lang('Gateway')">
                                                    <b>{{ __($data->method->name) }}</b>
                                                </td>
                                                <td data-label="@lang('Amount')">
                                                    <b>{{getAmount($data->amount)}} {{__($general->cur_text)}}</b>
                                                </td>
                                                <td data-label="@lang('Charge')">
                                                    <b>{{getAmount($data->charge)}} {{__($general->cur_text)}}</b>
                                                </td>
                                                <td data-label="@lang('After Charge')">
                                                    <b>{{getAmount($data->after_charge)}} {{__($general->cur_text)}}</b>
                                                </td>
                                                <td data-label="@lang('Rate')">
                                                    <b>{{getAmount($data->rate)}} {{__($data->currency)}}</b>
                                                </td>
                                                <td data-label="@lang('Receivable')">
                                                    <b>{{getAmount($data->final_amount)}} {{__($data->currency)}}</b>
                                                </td>
                                                <td data-label="@lang('Status')">


                                                    @if($data->status == 1)
                                                        <span class="badge badge--success">@lang('Complete')</span>
                                                        <button class="btn--info btn-rounded  badge approveBtn" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></button>
                                                    @elseif($data->status == 2)
                                                        <span class="badge badge--warning">@lang('Pending')</span>
                                                    @elseif($data->status == 3)
                                                        <span class="badge badge--danger">@lang('Rejected')</span>
                                                        <button class="btn--info btn-rounded badge approveBtn" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></button>

                                                    @endif


                                                </td>
                                                <td data-label="@lang('Time')"> {{showDateTime($data->created_at)}}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="100%">@lang('No data found')</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="pagination--sm justify-content-end">
                                    {{$withdraws->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="detailModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Details')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="withdraw-detail"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('script')
    <script>
        $(function(){
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');

                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        });

    </script>
@endpush
