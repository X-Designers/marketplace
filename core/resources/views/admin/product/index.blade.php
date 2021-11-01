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
                                    <th scope="col">@lang('SL')</th>
                                    <th scope="col">@lang('Image')</th>
                                    <th scope="col">@lang('Author')</th>
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Category')</th>
                                    <th scope="col">@lang('Subcategory')</th>
                                    @if (request()->routeIs('admin.product.approved'))
                                        <th scope="col">@lang('Featured')</th>
                                    @endif
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody class="list">
                                @forelse ($products as $item)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                        <td data-label="@lang('Image')">
                                            <div class="user justify-content-center">
                                                @if(request()->routeIs('admin.product.update.pending') || request()->routeIs('admin.product.resubmit'))
                                                    <div class="thumb"><img src="{{ getImage(imagePath()['temp_p_image']['path'].'/thumb_'. $item->image,imagePath()['temp_p_image']['size'])}}" alt="@lang('image')"></div>
                                                @else
                                                    <div class="thumb"><img src="{{ getImage(imagePath()['p_image']['path'].'/thumb_'. $item->image,imagePath()['p_image']['size'])}}" alt="@lang('image')"></div>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-label="@lang('Author')"><a href="{{route('admin.users.detail',$item->user->id)}}">{{ $item->user->username }}</a></td>
                                        <td data-label="@lang('Name')">{{ $item->name }}</td>
                                        <td data-label="@lang('Category')">{{ $item->category->name }}</td>
                                        <td data-label="@lang('Subcategory')">{{ $item->subcategory->name }}</td>

                                        @if (request()->routeIs('admin.product.approved'))
                                            <td data-label="@lang('Featured')">
                                                @if ($item->featured == 1)
                                                    <span class="badge badge--primary">@lang('Yes')</span>
                                                @else
                                                    <span class="badge badge--danger">@lang('No')</span>
                                                @endif
                                            </td>
                                        @endif

                                        <td data-label="@lang('Action')">

                                            @if(request()->routeIs('admin.product.update.pending'))
                                                <a href="{{route('admin.product.update.pending.download',Crypt::encrypt($item->id))}}" data-toggle="tooltip" title="@lang('Download')" data-original-title="@lang('Download')" class="icon-btn updateBtn"><i class="las la-download"></i></a>

                                                <a href="{{route('admin.product.update.pending.view',Crypt::encrypt($item->id))}}" class="icon-btn updateBtn"><i class="las la-eye"></i></a>
                                            @elseif(request()->routeIs('admin.product.resubmit'))

                                                <a href="javascript:void(0)" class="icon-btn bg--warning" data-toggle="modal" data-target="#previous-soft-issue{{$loop->index}}"><i class="las la-exclamation-triangle"></i></a>

                                                <a href="{{route('admin.product.resubmit.download',Crypt::encrypt($item->id))}}" data-toggle="tooltip" title="@lang('Download')" data-original-title="@lang('Download')" class="icon-btn updateBtn"><i class="las la-download"></i></a>

                                                <a href="{{route('admin.product.resubmit.view',Crypt::encrypt($item->id))}}" class="icon-btn updateBtn"><i class="las la-eye"></i></a>
                                            @else
                                                @if ($item->status == 2)
                                                        <a href="javascript:void(0)" class="icon-btn bg--warning" data-toggle="modal" data-target="#soft-issue{{$loop->index}}"><i class="las la-exclamation-triangle"></i></a>
                                                @elseif ($item->status == 3)
                                                    <a href="javascript:void(0)" class="icon-btn bg--danger" data-toggle="modal" data-target="#hard-issue{{$loop->index}}"><i class="las la-exclamation-triangle"></i></a>
                                                @endif
                                                @if ($item->status ==1)
                                                    @if ($item->featured == 1)
                                                        <a href="javascript:void(0)" class="icon-btn bg--danger" data-toggle="modal" data-target="#unFeaturedModal{{$loop->index}}"><i class="las la-haykal"></i></a>
                                                    @else
                                                        <a href="javascript:void(0)" class="icon-btn" data-toggle="modal" data-target="#featuredModal{{$loop->index}}"><i class="las la-haykal"></i></a>
                                                    @endif
                                                @endif

                                                <a href="{{route('admin.product.download',Crypt::encrypt($item->id))}}" data-toggle="tooltip" title="@lang('Download')" data-original-title="@lang('Download')" class="icon-btn"><i class="las la-download"></i></a>
                                                <a href="{{route('admin.product.view',Crypt::encrypt($item->id))}}" class="icon-btn"><i class="las la-eye"></i></a>
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

                                        @if(request()->routeIs('admin.product.resubmit'))
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

                                        <div id="featuredModal{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">@lang('Make Featured Confirmation')</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.featured.product') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$item->id}}">
                                                        <div class="modal-body">
                                                            <p>@lang('Are you sure to make this product featured?')</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                                                            <button type="submit" class="btn btn--primary">@lang('Make Featured')</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="unFeaturedModal{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text--danger">@lang('Make Unfeatured Confirmation')</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.unfeatured.product') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$item->id}}">
                                                        <div class="modal-body">
                                                            <p>@lang('Are you sure to make this product unfeatured?')</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                                                            <button type="submit" class="btn btn--danger">@lang('Make Unfeatured')</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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
                    {{ $products->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>
@endsection

