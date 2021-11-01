@extends('reviewer.layouts.app')

@section('panel')

    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 mb-30">

            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body p-0">
                    <div class="p-3 bg--white">
                        <div class="">
                            <img src="{{ getImage(imagePath()['profile']['reviewer']['path'].'/'.$reviewer->image,imagePath()['profile']['reviewer']['size'])}}" alt="@lang('Profile Image')" class="b-radius--10 w-100">
                        </div>
                        <div class="mt-15">
                            <h4 class="">{{$reviewer->fullname}}</h4>
                            <span class="text--small">@lang('Joined At') <strong>{{showDateTime($reviewer->created_at,'d M, Y h:i A')}}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
            <form action="{{ route('reviewer.password.update') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-50 border-bottom pb-2"> @lang('Change Password')</h5>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Password')<span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" name="old_password">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('New Password') <span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" name="password">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Confirm Password') <span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" name="password_confirmation">
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
            </form>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('reviewer.profile')}}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="fa fa-user"></i>@lang('Profile Setting')</a>
@endpush
