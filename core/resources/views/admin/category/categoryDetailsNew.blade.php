@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{route('admin.category.details.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="card">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Category Name')</label>
                                            <input class="form-control" type="text" value="{{$category->name}}" disabled>
                                            <input type="hidden" name="category_id" value="{{$category->id}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>@lang('Subject Name')</label>
                                            <input name="name" class="form-control" type="text" placeholder="@lang('Enter subject name')" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>@lang('Select Type')</label>
                                            <select name="type" class="form-control" required>
                                                <option value="1">@lang('Single')</option>
                                                <option value="2">@lang('Multiple')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="payment-method-item p-2">
                                    <div class="payment-method-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card border--primary">
                                                    <h5 class="card-header bg--primary  text-white">@lang('Add Options')
                                                        <button type="button" class="btn btn-sm btn-outline-light float-right addUserData"><i class="la la-fw la-plus"></i>@lang('Add New')
                                                        </button>
                                                    </h5>

                                                    <div class="card-body addedField">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <div class="input-group mb-md-0">
                                                                        <input name="options[]" class="form-control" type="text" placeholder="@lang('Enter option')" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.category.details',$category->id)}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i>@lang('Go Back')</a>
@endpush

@push('script')
<script>
    'use strict';

    (function ($) {

        $('.addUserData').on('click', function () {
                var html = `
                <div class="row user-data">
                    <div class="col-md-11">
                        <div class="form-group">
                            <div class="input-group mb-md-0">
                                <input name="options[]" class="form-control" type="text" placeholder="@lang('Enter option')" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                                <button class="btn btn--danger btn-lg removeBtn w-100 mt-28 text-center" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                        <div class="form-group">
                    </div>
                </div>`;
                $('.addedField').append(html)
            });

            $(document).on('click', '.removeBtn', function () {
                $(this).closest('.user-data').remove();
            });
        })(jQuery);
</script>
@endpush
