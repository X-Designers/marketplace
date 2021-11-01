@extends($activeTemplate.'layouts.frontend')

@section('content')
@include($activeTemplate.'partials.dashboardHeader')
    <div class="pb-100">
        <div class="dashboard-area pt-50">
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                <div class="tab-content-area">
                    <div class="user-profile-area">
                        <h4 class="mb-4 text-center">@lang('Change Password')</h4>
                    <form  action="" method="post">
                        @csrf
                        <div class="form-group">
                        <label>@lang('Current Password')</label>
                        <input type="password" name="current_password" placeholder="@lang('Enter current password')" class="form--control">
                        </div>
                        <div class="form-group">
                        <label>@lang('New Password')</label>
                        <input type="password" name="password" placeholder="@lang('Enter new password')" class="form--control">
                        </div>
                        <div class="form-group">
                        <label>@lang('Confirm Password')</label>
                        <input type="password" name="password_confirmation" placeholder="@lang('Enter confirm password')" class="form--control">
                        </div>
                        <div class="text-end">
                        <button type="submit" class="btn btn--base w-100">@lang('Update Now')</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

