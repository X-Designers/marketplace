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
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Buyer Fee')</th>
                                    <th scope="col">@lang('Product Count')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($categories as $item)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                        <td data-label="@lang('Image')">
                                            <div class="user justify-content-center">
                                                <div class="thumb"><img src="{{ getImage(imagePath()['category']['path'].'/'. $item->image,imagePath()['category']['size'])}}" alt="@lang('image')"></div>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Name')">{{ $item->name }}</td>
                                        <td data-label="@lang('Buyer Fee')">{{ getAmount($item->buyer_fee) }} {{$general->cur_text}}</td>
                                        <td data-label="@lang('Product Count')">{{ $item->products->count() }}</td>
                                        <td data-label="@lang('Action')">

                                            <a href="{{ route('admin.category.details',$item->id) }}" class="icon-btn btn--info mr-1" data-toggle="tooltip" title="@lang('Category Details')" data-original-title="@lang('Category Details')">
                                                <i class="las la-info-circle text--shadow"></i>
                                            </a>

                                            <a href="{{ route('admin.category.sub',$item->id) }}" class="icon-btn btn--success mr-1" data-toggle="tooltip" title="@lang('Subcategory')" data-original-title="@lang('SubCategory')">
                                                <i class="las la-tags text--shadow"></i>
                                            </a>

                                            <a href="#" class="icon-btn updateBtn"  data-route="{{ route('admin.category.update',$item->id) }}" data-resourse="{{$item}}" data-toggle="modal" data-target="#updateBtn" data-image="{{ getImage(imagePath()['category']['path'].'/'. $item->image,imagePath()['category']['size'])}}" ><i class="la la-pencil-alt"></i></a>

                                            @if ($item->status == 0)
                                                <button type="button"
                                                        class="icon-btn btn--success ml-1 activateBtn"
                                                        data-toggle="modal" data-target="#activateModal"
                                                        data-id="{{$item->id}}"
                                                        data-original-title="@lang('Enable')">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            @else
                                                <button type="button"
                                                        class="icon-btn btn--danger ml-1 deactivateBtn"
                                                        data-toggle="modal" data-target="#deactivateModal"
                                                        data-id="{{$item->id}}"
                                                        data-original-title="@lang('Disable')">
                                                    <i class="la la-eye-slash"></i>
                                                </button>
                                            @endif
                                        </td>
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
                    {{ $categories->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Add METHOD MODAL --}}
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add New Category')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Category Name')</label>
                            <input type="text"class="form-control" placeholder="@lang('Enter Name')" name="name" required>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Buyer Fee')</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input type="number" class="form-control" name="buyer_fee" placeholder="@lang('Buyer Fee')" step="any" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{$general->cur_text}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <b>@lang('Category Image')</b>
                            <div class="image-upload mt-2">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview" style="background-image: url({{ getImage('',imagePath()['category']['size']) }})">
                                            <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload1" class="bg--success"> @lang('image')</label>
                                        <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>.
                                        @lang('Image Will be resized to'): <b>{{imagePath()['category']['size']}}</b> @lang('px').

                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Update METHOD MODAL --}}
    <div id="updateBtn" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Update Category')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="edit-route" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Category Name')</label>
                            <input type="text"class="form-control name" placeholder="@lang('Enter Name')" name="name" required>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Buyer Fee')</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input type="number" class="form-control buyer-fee" name="buyer_fee" placeholder="@lang('Buyer Fee')" step="any" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{$general->cur_text}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <b>@lang('Category Image')</b>
                            <div class="image-upload mt-2">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview update-image-preview">
                                            <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload2" class="bg--success"> @lang('image')</label>
                                        <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>.
                                        @lang('Image Will be resized to'): <b>{{imagePath()['category']['size']}}</b> @lang('px').

                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Category Activation Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.category.activate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to activate this category?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Activate')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- DEACTIVATE METHOD MODAL --}}
    <div id="deactivateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Category Disable Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.category.deactivate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to disable this category')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Disable')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('breadcrumb-plugins')
        <a href="javascript:void(0)" class="btn btn-sm btn--primary box--shadow1 text--small addBtn mb-4"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a><br>
        @if(request()->routeIs('admin.category'))
            <form action="{{ route('admin.category.search') }}" method="GET" class="form-inline float-sm-right bg--white">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('Category Name')" value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        @else
            <form action="{{ route('admin.category.search') }}" method="GET" class="form-inline float-sm-right bg--white">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('Category Name')" value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        @endif
    @endpush
@endsection

@push('script')
<script>
    'use strict';

    (function ($) {
        $('.addBtn').on('click', function () {
            var modal = $('#addModal');
            modal.modal('show');
        });

        $('.updateBtn').on('click', function () {
            var modal = $('#updateBtn');

            var resourse = $(this).data('resourse');

            var route = $(this).data('route');
            $('.name').val(resourse.name);
            $('.buyer-fee').val(resourse.buyer_fee);
            $('.update-image-preview').css({"background-image": "url("+$(this).data('image')+")"});
            $('.edit-route').attr('action',route);

        });

        $('.activateBtn').on('click', function () {
            var modal = $('#activateModal');
            modal.find('input[name=id]').val($(this).data('id'));
        });

        $('.deactivateBtn').on('click', function () {
            var modal = $('#deactivateModal');
            modal.find('input[name=id]').val($(this).data('id'));
        });
    })(jQuery);
</script>
@endpush
