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
                                    <th scope="col">@lang('Minimun Earning')</th>
                                    <th scope="col">@lang('Author Fee')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($levels as $item)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                        <td data-label="@lang('Image')">
                                            <div class="user justify-content-center">
                                                <div class="thumb"><img src="{{ getImage(imagePath()['level']['path'].'/'. $item->image,imagePath()['level']['size'])}}" alt="@lang('image')"></div>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Name')">{{ $item->name }}</td>
                                        <td data-label="@lang('Minimun Earning')">{{$general->cur_sym}}{{ getAmount($item->earning) }}</td>
                                        <td data-label="@lang('Author Fee')">{{ $item->product_charge }}%</td>
                                        <td data-label="@lang('Action')">
                                            <a href="#" class="icon-btn updateBtn" data-route="{{ route('admin.level.update',$item->id) }}" data-resourse="{{$item}}" data-toggle="modal" data-target="#updateBtn" data-image="{{ getImage(imagePath()['level']['path'].'/'. $item->image,imagePath()['level']['size'])}}" ><i class="la la-pencil-alt"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $levels->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Add METHOD MODAL --}}
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add New Level')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.level.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Level Name')</label>
                            <input type="text"class="form-control" placeholder="@lang('Enter Name')" name="name" required>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Minimum Earning')</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input type="number" class="form-control" name="earning" placeholder="@lang('Enter minimum earnig')" step="any" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{$general->cur_text}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Author Fee')</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input type="number" class="form-control" name="product_charge" placeholder="@lang('Enter charge for product per sell')" step="any" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">%</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <b>@lang('Level Image')</b>
                            <div class="image-upload mt-2">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview" style="background-image: url({{ getImage('',imagePath()['level']['size']) }})">
                                            <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload1" class="bg--success"> @lang('image')</label>
                                        <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>.
                                        @lang('Image Will be resized to'): <b>{{imagePath()['level']['size']}}</b> @lang('px').

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
                    <h5 class="modal-title"> @lang('Update Level')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="edit-route" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Level Name')</label>
                            <input type="text"class="form-control name" placeholder="@lang('Enter Name')" name="name" required>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Minimum Earning')</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input type="number" class="form-control earning" name="earning" placeholder="@lang('Enter minimum earnig')" step="any" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{$general->cur_text}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Author Fee')</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input type="number" class="form-control product-charge" name="product_charge" placeholder="@lang('Enter charge for product per sell')" step="any" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">%</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <b>@lang('Level Image')</b>
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
                                        @lang('Image Will be resized to'): <b>{{imagePath()['level']['size']}}</b> @lang('px').

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

    @push('breadcrumb-plugins')
        <a href="javascript:void(0)" class="btn btn-sm btn--primary box--shadow1 text--small addBtn mb-4"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a><br>
        @if(request()->routeIs('admin.level'))
            <form action="{{ route('admin.level.search') }}" method="GET" class="form-inline float-sm-right bg--white">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('Level Name')" value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        @else
            <form action="{{ route('admin.level.search') }}" method="GET" class="form-inline float-sm-right bg--white">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('Level Name')" value="{{ $search ?? '' }}">
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
            if (resourse.default_status == 1) {
                $('.earning').val(resourse.earning).prop('readonly', true);
            }
            if (resourse.default_status == 0) {
                $('.earning').val(resourse.earning);
            }
            $('.product-charge').val(resourse.product_charge);
            $('.update-image-preview').css({"background-image": "url("+$(this).data('image')+")"});
            $('.edit-route').attr('action',route);

        });

    })(jQuery);
</script>
@endpush
