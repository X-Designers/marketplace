@extends($activeTemplate.'layouts.frontend')

@push('style')
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/starrr.css')}}">
@endpush

@section('content')

<div class="pb-100">
    @include($activeTemplate.'partials.dashboardHeader')
    <div class="dashboard-area pt-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive--md mt-4">
                        <table class="table custom--table">
                        <thead>
                            <tr>
                                <th>@lang('Purchase Code')</th>
                                <th>@lang('Product Name')</th>
                                <th>@lang('Support')</th>
                                <th>@lang('Purchased At')</th>
                                <th>@lang('Support End')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $key => $item)
                                <tr>
                                    <td data-label="@lang('Purchase Code')">
                                        <b>{{$item->code}}</b>
                                    </td>
                                    <td data-label="@lang('Purchase Name')">
                                        <b>{{__($item->product->name)}}</b>
                                    </td>
                                    <td data-label="@lang('Support')">
                                        @if ($item->support == 1)
                                            <b>@lang('Yes')</b>
                                        @elseif($item->support == 0)
                                            <b>@lang('No')</b>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Purchased At')">
                                        {{showDateTime($item->created_at,'d M, Y')}}
                                    </td>
                                    <td data-label="@lang('Support End')">
                                        @if ($item->support_time)
                                            <b>{{showDateTime($item->support_time,'d M, Y')}}</b>
                                        @else
                                            @lang('N/A')
                                        @endif
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if ($item->status == 1)
                                            <span class="badge badge--success">@lang('Purchased')</span>
                                        @elseif($item->status == 2)
                                            <span class="badge badge--danger">@lang('Rejected')</span>
                                        @elseif($item->status == 0)
                                            <span class="badge badge--warning">@lang('Pending')</span>
                                        @else
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        @if ($item->status == 1)
                                            <a href="{{route('user.download',Crypt::encrypt($item->product->id))}}" class="icon-btn bg--primary"><i class="las la-download" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Download')"></i></a>
                                            <a href="{{route('user.invoice',Crypt::encrypt($item->product->id))}}" class="icon-btn bg--primary"><i class="las la-receipt" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Invoice')"></i></a>

                                            @if (!auth()->user()->existedRating($item->product->id))
                                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#reviewModal" class="icon-btn bg--primary reviewBtn" data-id="{{$item->product->id}}"><i class="las la-star-of-david" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Give Review')"></i></a>
                                            @endif
                                        @elseif($item->status == 2)
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#messageModal{{$loop->index}}" class="icon-btn bg--primary reviewBtn" data-id="{{$item->product->id}}"><i class="las la-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Message')"></i></a>
                                        @endif
                                    </td>

                                    <div class="modal fade" id="messageModal{{$loop->index}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4>@lang('Rejection Message')</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <p>{{__($item->reject_message)}}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-md px-4 btn--base" data-bs-dismiss="modal">@lang('Got it')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">{{__($empty_message)}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                        </table>
                        <div class="pagination--sm justify-content-end">
                            {{$products->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(count($products) > 0)
    <div class="modal fade" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('user.rating')}}" method="POST">
                    @csrf
                        <div class="modal-header">
                            <h4>@lang('Give Review')</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="">@lang('Give your rating')</label><br>
                                    <div class='starrr' id='star{{ $key }}'></div>
                                    <input type='hidden' name='rating' value='0' id='star2_input' required>
                                    <input type="hidden" name="product_id" value="" required>

                                    <div class="form-group">
                                        <label for="">@lang('Write your opinion')</label>
                                        <textarea name="review" rows="5" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-md px-4 btn--danger" data-bs-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn-md px-4 btn--base">@lang('Yes')</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection

@push('script')
    <script src="{{asset($activeTemplateTrue.'js/starrr.js')}}"></script>

    <script>

        'use strict';

        $('.reviewBtn').on('click', function () {
            var modal = $('#reviewModal');
            modal.find('input[name=product_id]').val($(this).data('id'));

            var $s2input = $('input[name=rating]');
            var indx = @php echo $products->count() @endphp;
            var i = 0;
            for (i; i < indx; i++) {
                $(`#star${i}`).starrr({
                    max: 5,
                    rating: $s2input.val(),
                    change: function(e, value){
                        $s2input.val(value).trigger('input');
                    }
                });
            }
        });
    </script>
@endpush
