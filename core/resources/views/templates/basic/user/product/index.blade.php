@extends($activeTemplate.'layouts.frontend')
@section('content')

    <div class="pb-100">
        @include($activeTemplate.'partials.dashboardHeader')

        <div class="dashboard-area pt-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-end">
                            <a class="btn btn-sm btn--base" href="{{route('user.product.new')}}">
                                <i class="las la-plus-circle fs-6"></i> @lang('Add New')
                            </a>
                        </div>
                        <div class="table-responsive--md mt-4">

                            <table class="table custom--table">
                                <thead>
                                    <tr>
                                        <th>@lang('Name')</th>
                                        <th>@lang('Category')</th>
                                        <th>@lang('Subcategory')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Total Sell')</th>
                                        <th>@lang('Update Status')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $item)

                                        <tr>
                                            <td data-label="@lang('Name')">{{ __($item->name) }}</td>
                                            <td data-label="@lang('Category')">
                                                <b>{{ __($item->category->name) }}</b>
                                            </td>
                                            <td data-label="@lang('Subcategory')">
                                                <b>{{ __($item->subcategory->name) }}</b>
                                            </td>

                                            <td data-label="@lang('Status')">
                                                @if($item->status == 0)
                                                    <span class="badge badge--warning">@lang('Pending')</span>
                                                @elseif($item->status == 1)
                                                    <span class="badge badge--success">@lang('Approved')</span>
                                                @elseif($item->status == 2)
                                                    <span class="badge badge--warning">@lang('Soft Reject')</span> <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#softMessageModal{{$loop->index}}" data-id="{{$item->id}}"><span><i class="fas fa-info-circle"></i></span></a>
                                                @elseif($item->status == 3)
                                                    <span class="badge badge--danger">@lang('Hard Reject')</span> <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#hardMessageModal{{$loop->index}}"
                                                    data-id="{{$item->id}}"><span><i class="fas fa-info-circle"></i></span></a>
                                                @elseif($item->status == 5)
                                                    <span class="badge badge--warning">@lang('Resubmitted')</span>
                                                @endif
                                            </td>

                                            <td data-label="@lang('Total Sell')">
                                                @if ($item->status == 1)
                                                    {{$item->total_sell}}
                                                @else
                                                    0
                                                @endif
                                            </td>

                                            <td data-label="@lang('Update Status')">
                                                @if($item->status == 1 && $item->update_status == 1)
                                                    <span class="badge badge--warning">@lang('Pending')</span>
                                                @elseif($item->status == 1 && $item->update_status == 2)
                                                    <span class="badge badge--success">@lang('Approved')</span>
                                                @elseif($item->status == 1 && $item->update_status == 3)
                                                    <span class="badge badge--danger">@lang('Rejected')</span> <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#updateMessageModal{{$loop->index}}" data-id="{{$item->id}}"><span><i class="fas fa-info-circle"></i></span></a>
                                                @else
                                                    <b>@lang('N/A')</b>
                                                    </td>
                                                @endif
                                            </td>

                                            <td data-label="@lang('Action')">

                                                @if($item->status == 1 && ($item->update_status == 0 || $item->update_status == 2 || $item->update_status == 3))
                                                    <a href="{{route('user.product.edit',Crypt::encrypt($item->id))}}" class="icon-btn bg--primary"><i class="las la-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Update')"></i></a>
                                                    <a href="javascript:void(0)" class="icon-btn bg--danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$loop->index}}"><i class="lar la-trash-alt" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Delete')"></i></a>
                                                @endif

                                                @if($item->status == 2)
                                                    <a href="{{route('user.product.resubmit',Crypt::encrypt($item->id))}}" class="bg--primary text-white p-1 rounded">@lang('Resubmit')</a>
                                                @endif
                                            </td>

                                            <div id="deleteModal{{$loop->index}}" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">>
                                                <div class="modal-dialog">
                                                    <form action="{{route('user.product.delete')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{Crypt::encrypt($item->id)}}" required>
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">@lang('Delete Product')</h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>@lang('Are you sure you wnt to delete this product?')</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn--primary btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                                                                <button type="submit" class="btn btn--danger btn-sm">@lang('Delete')</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </tr>

                                        <div class="modal fade" id="hardMessageModal{{$loop->index}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-body p-4 text-center">
                                                        <h4 class="text-danger">@lang('Your Product Has Been Rejected'):(</h4>
                                                        <div class="row justify-content-center">
                                                        <div class="col-lg-12">
                                                            <hr>
                                                            <p>{{$item->hard_reject}}</p>
                                                            <hr>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-top-0">
                                                        <button type="button" class="btn btn--base w-100" data-bs-dismiss="modal">@lang('Ok, got it')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="softMessageModal{{$loop->index}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-body p-4 text-center">
                                                        <h4 class="text-danger">@lang('Your Product Has Been Soft Rejected'):(</h4>
                                                        <div class="row justify-content-center">
                                                        <div class="col-lg-12">
                                                            <hr>
                                                            <p>{{$item->soft_reject}}</p>
                                                            <hr>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-top-0">
                                                        <button type="button" class="btn btn--base w-100" data-bs-dismiss="modal">@lang('Ok, got it')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="updateMessageModal{{$loop->index}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-body p-4 text-center">
                                                        <h4 class="text-danger">@lang('Update Of Your Product Has Been Rejected'):(</h4>
                                                        <div class="row justify-content-center">
                                                        <div class="col-lg-12">
                                                            <hr>
                                                            <p>{{$item->update_reject}}</p>
                                                            <hr>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-top-0">
                                                        <button type="button" class="btn btn--base w-100" data-bs-dismiss="modal">@lang('Ok, got it')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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


@endsection
