@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body p-0">
                    <div class="p-3 bg--white">
                        <div class="">
                            <img src="{{ getImage(imagePath()['profile']['reviewer']['path'].'/'. $reviewer->image,imagePath()['profile']['reviewer']['size'])}}" alt="@lang('profile-image')"
                                 class="b-radius--10 w-100">
                        </div>
                        <div class="mt-15">
                            <h4 class="">{{ __($reviewer->name) }}</h4>
                            <span class="text--small">@lang('Joined At') <strong>{{date('d M, Y h:i A',strtotime($reviewer->created_at))}}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Reviewer information')</h5>
                    <ul class="list-group">

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="font-weight-bold">{{$reviewer->username}}</span>
                        </li>


                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @switch($reviewer->status)
                                @case(1)
                                <span class="badge badge-pill bg--success">@lang('Active')</span>
                                @break
                                @case(0)
                                <span class="badge badge-pill bg--danger">@lang('Banned')</span>
                                @break
                            @endswitch
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Reviewer action')</h5>
                    <a href="{{ route('admin.reviewers.login.history.single', $reviewer->id) }}"
                       class="btn btn--primary btn--shadow btn-block btn-lg">
                        @lang('Login Logs')
                    </a>
                    <a href="{{route('admin.reviewers.email.single',$reviewer->id)}}"
                       class="btn btn--danger btn--shadow btn-block btn-lg">
                        @lang('Send Email')
                    </a>
                </div>
            </div>
        </div>



        <div class="col-xl-9 col-lg-7 col-md-7 mb-30">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">{{$reviewer->name}} @lang('Information')</h5>

                    <form action="{{ route('admin.reviewers.update',$reviewer->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('First Name') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="firstname"
                                           value="{{$reviewer->firstname}}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Last Name') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="lastname"
                                           value="{{$reviewer->lastname}}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Email') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" value="{{$reviewer->email}}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Mobile Number') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="mobile" value="{{$reviewer->mobile}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Address') <span
                                        class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="address"
                                           value="{{@$reviewer->address->address}}" required>
                                    <small class="form-text text-muted"><i class="las la-info-circle"></i> @lang('House number,
                                        street address')
                                    </small>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label font-weight-bold">@lang('City') </label>
                                    <input class="form-control" type="text" name="city" value="{{@$reviewer->address->city}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('State') </label>
                                    <input class="form-control" type="text" name="state" value="{{@$reviewer->address->state}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Zip/Postal') </label>
                                    <input class="form-control" type="text" name="zip" value="{{@$reviewer->address->zip}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Country') </label>
                                    <select name="country" class="form-control"> @include('partials.country') </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Banned')" data-width="100%"
                                       name="status"
                                       @if($reviewer->status) checked @endif>
                            </div>

                            <div class="form-group  col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('Email Verification') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="ev"
                                       @if($reviewer->ev) checked @endif>

                            </div>

                            <div class="form-group  col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('SMS Verification') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="sv"
                                       @if($reviewer->sv) checked @endif>

                            </div>

                            <div class="form-group  col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('2FA Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Deactive')" name="ts"
                                       @if($reviewer->ts) checked @endif>
                            </div>

                            <div class="form-group  col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('2FA Verification') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="tv"
                                       @if($reviewer->tv) checked @endif>
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
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        "use strict";
        $("select[name=country]").val("{{ @$reviewer->address->country }}");
    </script>
@endpush



