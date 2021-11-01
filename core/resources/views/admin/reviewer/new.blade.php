@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.reviewers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <b>@lang('Reviewer Image')</b>
                                    <div class="image-upload mt-2">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage('/',imagePath()['profile']['reviewer']['size']) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload1" class="bg--success"> @lang('image')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>.
                                                @lang('Image Will be resized to'): <b>{{imagePath()['profile']['reviewer']['size']}}</b> @lang('px').

                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Full Name')</label>
                                            <input type="text"class="form-control" placeholder="@lang('Enter Firstname')" value="{{ old('firstname') }}" name="firstname" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Full Name')</label>
                                            <input type="text"class="form-control" placeholder="@lang('Enter Lastname')" value="{{ old('lastname') }}" name="lastname" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Username')</label>
                                            <input type="text"class="form-control" placeholder="@lang('Choose usename')" name="username" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('E-mail')</label>
                                            <input type="email"class="form-control" placeholder="@lang('Enter a valid email')" name="email" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Password')</label>
                                            <input type="password"class="form-control" name="password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Confirm Password')</label>
                                            <input type="password" class="form-control" name="password_confirmation" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>@lang('Contact No')</label>
                                            <input type="tel"class="form-control" name="mobile" placeholder="@lang('Enter mobile number')" value="{{ old('mobile') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label>@lang('Address')</label>
                                            <input type="text"class="form-control" name="address" placeholder="@lang('Enter address')" value="{{ old('address') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('City') </label>
                                            <input class="form-control" type="text" name="city" >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('State') </label>
                                            <input class="form-control" type="text" name="state">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Zip/Postal') </label>
                                            <input class="form-control" type="text" name="zip">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Country') </label>
                                            <select name="country" class="form-control"> @include('partials.country') </select>
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
    <a href="{{ route('admin.reviewers.all') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush

