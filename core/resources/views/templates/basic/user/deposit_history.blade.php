@extends($activeTemplate.'layouts.frontend')
    @section('content')

        <div class="pb-100">
            @include($activeTemplate.'partials.dashboardHeader')

            <div class="dashboard-area pt-50">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-end">
                                <a class="btn btn-sm btn--base" href="{{route('user.deposit')}}">
                                    <i class="las la-university fs-6"></i> @lang('Deposit Now')
                                </a>
                            </div>
                            <div class="table-responsive--md mt-4">

                                <table class="table custom--table">
                                    <thead>
                                        <tr>
                                            <th>@lang('Transaction ID')</th>
                                            <th>@lang('Gateway')</th>
                                            <th>@lang('Amount')</th>
                                            <th>@lang('Status')</th>
                                            <th>@lang('Time')</th>
                                            <th>@lang('More')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($logs as $k=>$data)

                                            <tr>
                                                <td data-label="@lang('Transaction ID')">{{$data->trx}}</td>
                                                <td data-label="@lang('Gateway')">
                                                    <b>{{ __(@$data->gateway->name)  }}</b>
                                                </td>
                                                <td data-label="@lang('Amount')">
                                                    <b>{{getAmount($data->amount)}} {{__($general->cur_text)}}</b>
                                                </td>
                                                <td data-label="@lang('Status')">
                                                    @if($data->status == 1)
                                                        <span class="badge badge--success">@lang('Complete')</span>
                                                    @elseif($data->status == 2)
                                                        <span class="badge badge--warning">@lang('Pending')</span>
                                                    @elseif($data->status == 3)
                                                        <span class="badge badge--danger">@lang('Cancleed')</span>
                                                    @endif

                                                    @if($data->admin_feedback != null)
                                                        <button class="btn--info btn-rounded  badge detailBtn" data-admin_feedback="{{$data->admin_feedback}}" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="las la-info"></i></button>
                                                    @endif
                                                </td>
                                                <td data-label="@lang('Time')"> {{showDateTime($data->created_at)}}</td>

                                                @php
                                                    $details = ($data->detail != null) ? json_encode($data->detail) : null;
                                                @endphp

                                                <td data-label="@lang('More')">
                                                    <a href="javascript:void(0)" class="icon-btn bg--primary approveBtn"
                                                    data-bs-toggle="modal" data-bs-target="#approveModal"
                                                    data-info="{{$details}}"
                                                    data-id="{{ $data->id }}"
                                                    data-amount="{{ getAmount($data->amount)}} {{ __($general->cur_text) }}"
                                                    data-charge="{{ getAmount($data->charge)}} {{ __($general->cur_text) }}"
                                                    data-after_charge="{{ getAmount($data->amount + $data->charge)}} {{ __($general->cur_text) }}"
                                                    data-rate="{{ getAmount($data->rate)}} {{ __($data->method_currency) }}"
                                                    data-payable="{{ getAmount($data->final_amo)}} {{ __($data->method_currency) }}"><i class="las la-desktop" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Details')"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="100%">@lang('No data found')</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="pagination--sm justify-content-end">
                                    {{$logs->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- APPROVE MODAL --}}
        <div id="approveModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Details')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item dark-bg">@lang('Amount') : <span class="withdraw-amount "></span></li>
                            <li class="list-group-item dark-bg">@lang('Charge') : <span class="withdraw-charge "></span></li>
                            <li class="list-group-item dark-bg">@lang('After Charge') : <span class="withdraw-after_charge"></span></li>
                            <li class="list-group-item dark-bg">@lang('Conversion Rate') : <span class="withdraw-rate"></span></li>
                            <li class="list-group-item dark-bg">@lang('Payable Amount') : <span class="withdraw-payable"></span></li>
                        </ul>
                        <ul class="list-group withdraw-detail mt-1">
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail MODAL --}}
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
    </div>
@endsection


@push('script')
    <script>
        "use strict";

        $('.approveBtn').on('click', function() {
            var modal = $('#approveModal');
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-charge').text($(this).data('charge'));
            modal.find('.withdraw-after_charge').text($(this).data('after_charge'));
            modal.find('.withdraw-rate').text($(this).data('rate'));
            modal.find('.withdraw-payable').text($(this).data('payable'));
            var list = [];
            var details =  Object.entries($(this).data('info'));

            var ImgPath = "{{asset(imagePath()['verify']['deposit']['path'])}}/";
            var singleInfo = '';
            for (var i = 0; i < details.length; i++) {
                if (details[i][1].type == 'file') {
                    singleInfo += `<li class="list-group-item">
                                        <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <img src="${ImgPath}/${details[i][1].field_name}" alt="@lang('Image')" class="w-100">
                                    </li>`;
                }else{
                    singleInfo += `<li class="list-group-item">
                                        <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <span class="font-weight-bold ml-3">${details[i][1].field_name}</span>
                                    </li>`;
                }
            }

            if (singleInfo)
            {
                modal.find('.withdraw-detail').html(`<br><strong class="my-3">@lang('Payment Information')</strong>  ${singleInfo}`);
            }else{
                modal.find('.withdraw-detail').html(`${singleInfo}`);
            }
            modal.modal('show');
        });

        $('.detailBtn').on('click', function() {
            var modal = $('#detailModal');
            var feedback = $(this).data('admin_feedback');
            console.log(feedback);
            modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
            modal.modal('show');
        });
    </script>
@endpush

