@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-12 col-md-12 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">@lang('Order Details')</h5>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Product Name')</th>
                                    <th scope="col">@lang('Category')</th>
                                    <th scope="col">@lang('Subcategory')</th>
                                    <th scope="col">@lang('License')</th>
                                    <th scope="col">@lang('Support')</th>
                                    <th scope="col">@lang('Support Time')</th>
                                    <th scope="col">@lang('Price')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $item)
                                    <tr>
                                        <td data-label="@lang('Product Name')">{{__($item->product->name)}}</td>
                                        <td data-label="@lang('Category')">{{__($item->product->category->name)}}</td>
                                        <td data-label="@lang('Subcategory')">{{__($item->product->subcategory->name)}}</td>
                                        <td data-label="@lang('License')">
                                            @if ($item->license == 1)
                                                @lang('Regular')
                                            @elseif ($item->license == 2)
                                                @lang('Extended')
                                            @endif
                                        </td>
                                        <td data-label="@lang('Support')">
                                            @if ($item->support == 1)
                                                @lang('Yes')
                                            @elseif ($item->support == 0)
                                                @lang('No')
                                            @endif
                                        </td>
                                        <td data-label="@lang('Support Time')">
                                            @if ($item->support_time)
                                                {{$item->support_time}}
                                            @else
                                                @lang('N/A')
                                            @endif
                                        </td>
                                        <td data-label="@lang('Price')">{{$general->cur_sym}}{{getAmount($item->total_price)}}</td>
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
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Payment Via') {{ __(@$deposit->gateway->name) }}</h5>
                    <div class="p-3 bg--white">
                        <img src="{{ $deposit->gateway_currency()->methodImage() }}" alt="@lang('Profile Image')" class="b-radius--10 deposit-imgView">
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Date')
                            <span class="font-weight-bold">{{ showDateTime($deposit->created_at) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Transaction Number')
                            <span class="font-weight-bold">{{ $deposit->trx }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="font-weight-bold">
                                <a href="{{ route('admin.users.detail', $deposit->user_id) }}">{{ @$deposit->user->username }}</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Method')
                            <span class="font-weight-bold">{{ __(@$deposit->gateway->name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Amount')
                            <span class="font-weight-bold">{{ getAmount($deposit->amount ) }} {{ __($general->cur_text) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Charge')
                            <span class="font-weight-bold">{{ getAmount($deposit->charge ) }} {{ __($general->cur_text) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('After Charge')
                            <span class="font-weight-bold">{{ getAmount($deposit->amount+$deposit->charge ) }} {{ __($general->cur_text) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Rate')
                            <span class="font-weight-bold">1 {{__($general->cur_text)}}
                                = {{ getAmount($deposit->rate) }} {{__($deposit->baseCurrency())}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Payable')
                            <span class="font-weight-bold">{{ getAmount($deposit->final_amo ) }} {{__($deposit->method_currency)}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @if($deposit->status == 2)
                                <span class="badge badge-pill bg--warning">@lang('Pending')</span>
                            @elseif($deposit->status == 1)
                                <span class="badge badge-pill bg--success">@lang('Approved')</span>
                            @elseif($deposit->status == 3)
                                <span class="badge badge-pill bg--danger">@lang('Rejected')</span>
                            @endif
                        </li>
                        @if($deposit->admin_feedback)
                            <li class="list-group-item">
                                <strong>@lang('Admin Response')</strong>
                                <br>
                                <p>{{__($deposit->admin_feedback)}}</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-md-6 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">@lang('User Payment Information')</h5>
                    @if($details != null)
                        @foreach(json_decode($details) as $k => $val)
                            @if($val->type == 'file')
                                <div class="row mt-4">
                                    <div class="col-md-8">
                                        <h6>{{inputTitle($k)}}</h6>
                                        <img src="{{getImage('assets/images/verify/deposit/'.$val->field_name)}}" alt="@lang('Image')">
                                    </div>
                                </div>
                            @else
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h6>{{inputTitle($k)}}</h6>
                                        <p>{{__($val->field_name)}}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    @if($deposit->status == 2)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button class="btn btn--success ml-1 approveBtn"
                                        data-id="{{ $deposit->id }}"
                                        data-info="{{$details}}"
                                        data-amount="{{ getAmount($deposit->amount)}} {{ __($general->cur_text) }}"
                                        data-username="{{ @$deposit->user->username }}"
                                        data-toggle="tooltip" data-original-title="@lang('Approve')"><i class="fas fa-check"></i>
                                    @lang('Approve')
                                </button>

                                <button class="btn btn--danger ml-1 rejectBtn"
                                        data-id="{{ $deposit->id }}"
                                        data-info="{{$details}}"
                                        data-amount="{{ getAmount($deposit->amount)}} {{ __($general->cur_text) }}"
                                        data-username="{{ @$deposit->user->username }}"
                                        data-toggle="tooltip" data-original-title="@lang('Reject')"><i class="fas fa-ban"></i>
                                    @lang('Reject')
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{-- APPROVE MODAL --}}
    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Approve Deposit Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.payment.approve')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to') <span class="font-weight-bold">@lang('approve')</span> <span class="font-weight-bold withdraw-amount text-success"></span> @lang('deposit of') <span class="font-weight-bold withdraw-user"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Approve')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reject Deposit Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.payment.reject')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to') <span class="font-weight-bold">@lang('reject')</span> <span class="font-weight-bold withdraw-amount text-success"></span> @lang('deposit of') <span class="font-weight-bold withdraw-user"></span>?</p>

                        <div class="form-group">
                            <label class="font-weight-bold mt-2">@lang('Reason for Rejection')</label>
                            <textarea name="message" id="message" placeholder="@lang('Reason for Rejection')" class="form-control" rows="5"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Reject')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";
        $('.approveBtn').on('click', function () {
            var modal = $('#approveModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-user').text($(this).data('username'));
            modal.modal('show');
        });

        $('.rejectBtn').on('click', function () {
            var modal = $('#rejectModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-user').text($(this).data('username'));
            modal.modal('show');
        });
    </script>
@endpush
