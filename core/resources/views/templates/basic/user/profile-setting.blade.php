@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'partials.dashboardHeader')

    <div class="pb-100">
        <div class="dashboard-area pt-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="tab-content-area">
                        <div class="user-profile-area">
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>@lang('Profile Cover Image')</label>
                                    <div class="user-profile-header p-0">
                                        <div class="profile-thumb product-profile-thumb">

                                            <div class="avatar-preview">
                                                <div class="profilePicPreview productPicPreview" style="background-image: url({{ getImage(imagePath()['profile']['cover']['path'].'/'. $user->cover_image,imagePath()['profile']['cover']['size']) }})"></div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type='file' name="cover_image" class="profilePicUpload" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload2"><i class="la la-pencil"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Profile Info')</label>
                                    <div class="user-profile-header">
                                        <div class="profile-thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['profile']['user']['path'].'/'. $user->image,imagePath()['profile']['user']['size']) }})"></div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type='file' name="image" class="profilePicUpload" id="profilePicUpload1" accept=".png, .jpg, .jpeg" />
                                                <label for="profilePicUpload1"><i class="la la-pencil"></i></label>
                                            </div>
                                        </div>
                                        <div class="content mt-2">
                                            <ul class="caption-list">
                                                <li>
                                                    <span class="caption">@lang('Full Name')</span>
                                                    <span class="value">{{$user->getFullnameAttribute()}}</span>
                                                </li>
                                                <li>
                                                    <span class="caption">@lang('E-mail')</span>
                                                    <span class="value">{{$user->email}}</span>
                                                </li>
                                                <li>
                                                    <span class="caption">@lang('Phone')</span>
                                                    <span class="value">{{$user->mobile}}</span>
                                                </li>
                                                <li>
                                                    <span class="caption">@lang('Country')</span>
                                                    <span class="value">{{@$user->address->country}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('First Name')</label>
                                        <input type="text" name="firstname" value="{{$user->firstname}}" class="form--control">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Last Name')</label>
                                        <input type="text" name="lastname" value="{{$user->lastname}}" class="form--control">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Address')</label>
                                        <input type="text" name="address" value="{{@$user->address->address}}" class="form--control">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('State')</label>
                                        <input type="text" name="state" value="{{@$user->address->state}}" class="form--control">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Zip Code')</label>
                                        <input type="text" name="zip" value="{{@$user->address->zip}}" class="form--control">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('City')</label>
                                        <input type="text" name="city" value="{{@$user->address->city}}" class="form--control">
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label>@lang('Description') <code>(@lang('HTML or plain text allowed'))</code></label>
                                        <textarea name="description" class="form-control nicEdit" rows="15" placeholder="@lang('Enter your message')">{{$user->description}}</textarea>
                                    </div>
                                    <div class="col-lg-12 form-group text-end">
                                        <button type="submit" class="btn btn--base w-100">@lang('Update Now')</button>
                                    </div>
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

@push('script')

    <!-- NicEdit js-->
    <script src="{{asset($activeTemplateTrue.'js/nicEdit.js')}}"></script>
    <script>
        'use strict';

        $("select[name='country']").val('{{$user->address->country}}');

        function proPicURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = $(input).parents('.profile-thumb').find('.profilePicPreview');
                    $(preview).css('background-image', 'url(' + e.target.result + ')');
                    $(preview).addClass('has-image');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".profilePicUpload").on('change', function() {
            proPicURL(this);
        });

        $(".remove-image").on('click', function(){
            $(".profilePicPreview").css('background-image', 'none');
            $(".profilePicPreview").removeClass('has-image');
        });

        bkLib.onDomLoaded(function() {
            $( ".nicEdit" ).each(function( index ) {
                $(this).attr("id","nicEditor"+index);
                new nicEditor({fullPanel : true}).panelInstance('nicEditor'+index,{hasPanel : true});
            });
        });

        $( document ).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain',function(){
            $('.nicEdit-main').focus();
        });
    </script>
@endpush
