@extends('reviewer.layouts.app')

@section('panel')

    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('SL')</th>
                                    <th scope="col">@lang('Image')</th>
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Category')</th>
                                    <th scope="col">@lang('Subcategory')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody class="list">
                                @forelse ($products as $item)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                        <td data-label="@lang('Image')">
                                            <div class="user justify-content-center">
                                                @if(request()->routeIs('reviewer.product.update.pending') || request()->routeIs('reviewer.product.resubmit'))
                                                    <div class="thumb"><img src="{{ getImage(imagePath()['temp_p_image']['path'].'/thumb_'. $item->image,imagePath()['temp_p_image']['size'])}}" alt="@lang('image')"></div>
                                                @else
                                                    <div class="thumb"><img src="{{ getImage(imagePath()['p_image']['path'].'/thumb_'. $item->image,imagePath()['p_image']['size'])}}" alt="@lang('image')"></div>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-label="@lang('Name')">{{ $item->name }}</td>
                                        <td data-label="@lang('Category')">{{ $item->category->name }}</td>
                                        <td data-label="@lang('Subcategory')">{{ $item->subcategory->name }}</td>
                                        <td data-label="@lang('Action')">

                                            @if(request()->routeIs('reviewer.product.update.pending'))
                                                <a href="{{route('reviewer.product.update.pending.download',Crypt::encrypt($item->id))}}"data-toggle="tooltip" title="@lang('Download')" data-original-title="@lang('Download')"  class="icon-btn updateBtn"><i class="las la-download"></i></a>

                                                <a href="{{route('reviewer.product.update.pending.view',Crypt::encrypt($item->id))}}" class="icon-btn updateBtn"><i class="las la-eye"></i></a>

                                            @elseif(request()->routeIs('reviewer.product.resubmit'))
                                                <a href="javascript:void(0)" class="icon-btn bg--warning" data-toggle="modal" data-target="#previous-soft-issue{{$loop->index}}"><i class="las la-exclamation-triangle"></i></a>

                                                <a href="{{route('reviewer.product.resubmit.download',Crypt::encrypt($item->id))}}" data-toggle="tooltip" title="@lang('Download')" data-original-title="@lang('Download')" class="icon-btn updateBtn"><i class="las la-download"></i></a>

                                                <a href="{{route('reviewer.product.resubmit.view',Crypt::encrypt($item->id))}}" class="icon-btn updateBtn"><i class="las la-eye"></i></a>
                                            @else
                                                @if ($item->status == 2)
                                                    <a href="javascript:void(0)" class="icon-btn bg--warning" data-toggle="modal" data-target="#soft-issue{{$loop->index}}"><i class="las la-exclamation-triangle"></i></a>
                                                @elseif ($item->status == 3)
                                                    <a href="javascript:void(0)" class="icon-btn bg--danger" data-toggle="modal" data-target="#hard-issue{{$loop->index}}"><i class="las la-exclamation-triangle"></i></a>
                                                @endif

                                                <a href="{{route('reviewer.product.download',Crypt::encrypt($item->id))}}" data-toggle="tooltip" title="@lang('Download')" data-original-title="@lang('Download')" class="icon-btn updateBtn"><i class="las la-download"></i></a>

                                                <a href="{{route('reviewer.product.view',Crypt::encrypt($item->id))}}" class="icon-btn updateBtn"><i class="las la-eye"></i></a>
                                            @endif
                                        </td>
                                        <div id="soft-issue{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">@lang('Soft Rejection Issue')</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{__($item->soft_reject)}}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="hard-issue{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">@lang('Hard Rejection Issue')</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{__($item->hard_reject)}}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if(request()->routeIs('reviewer.product.resubmit'))
                                            <div id="previous-soft-issue{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">@lang('Previous Soft Rejection Issue')</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{__($item->product->soft_reject)}}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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
                    {{ $products->links('reviewer.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>
@endsection

