@extends('reviewer.layouts.app')

@section('panel')

    <form action="{{ route('reviewer.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-none-30">
            <div class="col-xl-3 col-lg-5 col-md-5 mb-30">

                <div class="card b-radius--10 overflow-hidden box--shadow1">
                    <div class="card-body p-0">
                        <div class="p-3 bg--white">
                            <div class="form-group">
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['profile']['reviewer']['path'].'/'. $reviewer->image,imagePath()['profile']['reviewer']['size']) }})">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                            <label for="profilePicUpload1" class="bg--success">@lang('Upload Profile Image')</label>
                                            <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg')</b>. @lang('Image will be resized into') {{imagePath()['profile']['reviewer']['size']}} @lang('px')</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-50 border-bottom pb-2">{{$reviewer->fullname}} @lang('User Information')</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('First Name')<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="firstname" value="{{$reviewer->firstname}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Last Name') <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="lastname" value="{{$reviewer->lastname}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Email') <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" value="{{$reviewer->email}}" readonly required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Mobile Number') <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="mobile" value="{{$reviewer->mobile}}" readonly required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-xl-6 col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Address') </label>
                                    <input class="form-control" type="text" name="address" value="{{@$reviewer->address->address}}">
                                    <small class="form-text text-muted"><i class="las la-info-circle"></i> @lang('House number, street address')
                                    </small>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label font-weight-bold">@lang('City') </label>
                                    <input class="form-control" type="text" name="city" value="{{@$reviewer->address->city}}">
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('State') </label>
                                    <input class="form-control" type="text" name="state" value="{{@$reviewer->address->state}}">
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Zip/Postal') </label>
                                    <input class="form-control" type="text" name="zip" value="{{@$reviewer->address->zip}}">
                                </div>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('breadcrumb-plugins')
    <a href="{{route('reviewer.password')}}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="fa fa-key"></i>@lang('Password Setting')</a>
@endpush
