@extends($activeTemplate.'layouts.frontend')
@section('content')

    <div class="pb-100">
        @include($activeTemplate.'partials.dashboardHeader')

        <div class="dashboard-area pt-50">
            <div class="container">
                <div class="row justify-content-center mt-2">

                    @foreach($withdrawMethod as $data)

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="withdraw-card">
                                <div class="withdraw-card__header">
                                <div class="thumb">
                                    <img src="{{getImage(imagePath()['withdraw']['method']['path'].'/'. $data->image,imagePath()['withdraw']['method']['size'])}}" alt="@lang('image')">
                                </div>
                                <div class="content">
                                    <h5 class="title text-white">{{__($data->name)}}</h5>
                                </div>
                                </div>
                                <div class="withdraw-card__body">
                                    <ul class="withdraw-info-list text-center">
                                        <li>@lang('Limit') : <b>{{getAmount($data->min_limit)}} - {{getAmount($data->max_limit)}} {{__($general->cur_text)}}</b></li>
                                        <li>@lang('Charge') : <b>{{ getAmount($data->fixed_charge) }} {{$general->cur_text}} @if($data->percent_charge > 0)+ {{ getAmount($data->percent_charge) }}% @endif</b></li>
                                        <li >@lang('Processing Time') : {{$data->delay}}</li>
                                    </ul>
                                    <a href="javascript:void(0)" data-id="{{$data->id}}" data-resource="{{$data}}" type="button" class="btn btn-md btn--base w-100 mt-4 btn--capsule deposit" data-bs-toggle="modal" data-bs-target="#staticBackdrop">@lang('Withdraw Now')</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="{{route('user.withdraw.money')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title method-name" id="staticBackdropLabel"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <input type="hidden" name="currency" class="edit-currency" value="">
                    <input type="hidden" name="method_code" class="edit-method-code" value="">

                    <label>@lang('Amount')</label>
                    <div class="input-group">
                    <input type="text" id="amount" class="form--control" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="0.00" required=""  value="{{old('amount')}}" aria-describedby="basic-addon2">
                    <span class="input-group-text" id="basic-addon2">{{__($general->cur_text)}}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-sm btn--success">@lang('Confirm')</button>
                </div>
            </form>
          </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        "use strict";
        $(document).ready(function(){
            $('.deposit').on('click', function () {
                var result = $(this).data('resource');
                $('.method-name').text(`@lang('Payment By ') ${result.name}`);

                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.id);
            });
        });
    </script>
@endpush

