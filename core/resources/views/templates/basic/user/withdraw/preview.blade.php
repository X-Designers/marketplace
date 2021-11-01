@extends($activeTemplate.'layouts.frontend')
    @section('content')

    <div class="pb-100">
        @include($activeTemplate.'partials.dashboardHeader')

        <div class="dashboard-area pt-50">
            <div class="container">

                <div class="row">
                    <div class="col-xxl-4 col-lg-5 pe-xxl-5">
                        <div class="withdraw-preview-sidebar">
                            <div class="withdraw-preview-sidebar__header">
                            <div class="thumb">
                                <img src="{{getImage(imagePath()['withdraw']['method']['path'].'/'. $withdraw->method->image,imagePath()['withdraw']['method']['size'])}}" alt="@lang('image')">
                            </div>
                            <div class="content">
                                <h5 class="title text-white">{{__($withdraw->method->name)}}</h5>
                                <span class="text-white">@lang('Available') : <b class="text--base">{{ getAmount(auth()->user()->balance)}}  {{ __($general->cur_text) }}</b></span>
                            </div>
                            </div>
                            <ul class="caption-list mt-4">
                            <li>
                                <div class="caption">@lang('Request Amount')</div>
                                <div class="value">{{getAmount($withdraw->amount)  }} {{__($general->cur_text)}}</div>
                            </li>
                            <li class="text--danger">
                                <div class="caption">@lang('Withdtraw Charge')</div>
                                <div class="value">{{getAmount($withdraw->charge) }} {{__($general->cur_text)}}</div>
                            </li>
                            <li class="text--info">
                                <div class="caption">@lang('After Charge')</div>
                                <div class="value">{{getAmount($withdraw->after_charge) }} {{__($general->cur_text)}}</div>
                            </li>
                            <li>
                                <div class="caption">@lang('Conversion Rate')</div>
                                <div class="value">1 {{__($general->cur_text)}} : {{getAmount($withdraw->rate)  }} {{__($withdraw->currency)}}</div>
                            </li>
                            <li class="text--success">
                                <div class="caption">@lang('You will get')</div>
                                <div class="value">{{getAmount($withdraw->final_amount) }} {{__($withdraw->currency)}}</div>
                            </li>
                            </ul>
                            <div class="net-balance">@lang('Balance will be') : <b class="text--success">{{getAmount($withdraw->user->balance - ($withdraw->amount))}}</b></div>
                        </div>
                    </div>
                    <div class="col-xxl-8 col-lg-7 mt-lg-0 mt-4">
                        <form class="withdraw-form" action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <h5 class="mb-3">{{__($page_title)}}</h5>
                            @if($withdraw->method->user_data)
                                @foreach($withdraw->method->user_data as $k => $v)
                                    @if($v->type == "text")
                                        <div class="form-group">
                                            <label>{{__($v->field_level)}} @if($v->validation == 'required') <sup class="text--danger">*</sup> @endif</label>
                                            <input type="text" name="{{$k}}" value="{{old($k)}}" class="form--control"  @if($v->validation == "required") required @endif>
                                            @if ($errors->has($k))
                                                <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                            @endif
                                        </div>
                                    @elseif($v->type == "textarea")
                                        <div class="form-group">
                                            <label>{{__($v->field_level)}} @if($v->validation == 'required') <sup class="text--danger">*</sup> @endif</label>
                                            <textarea name="{{$k}}" class="form--control" rows="5"  @if($v->validation == "required") required @endif></textarea>
                                            @if ($errors->has($k))
                                                <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                            @endif
                                        </div>
                                    @elseif($v->type == "file")
                                        <div class="form-group">
                                            <label>{{__($v->field_level)}} @if($v->validation == 'required') <sup class="text--danger">*</sup> @endif</label>
                                            <div id="uploader" class="it">
                                                <div class="row uploadDoc">
                                                    <div class="col-xxl-6 col-xl-6">
                                                        <div class="fileUpload btn btn-orange">
                                                            <img src="{{asset('assets/images/first.svg')}}" class="icon">
                                                            <span class="upl fs-12px" id="upload">@lang('Upload')</span>
                                                            <input type="file" class="upload up" id="up" name="{{$k}}" accept="image/*" @if($v->validation == "required") required @endif onchange="readURL(this);" />
                                                            @if ($errors->has($k))
                                                                <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            <div class="text-end mt-5">
                                <button type="submit" class="btn btn--base w-100">@lang('Confirm')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

    <script>
        "use strict";

        var fileTypes = ['pdf', 'docx', 'rtf', 'jpg', 'jpeg', 'png', 'txt'];  //acceptable file types
        function readURL(input) {
            if (input.files && input.files[0]) {
                var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                    isSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types
                if (isSuccess) { //yes
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $(input).closest('.fileUpload').find(".icon").attr('src',`{{asset('assets/images/')}}/${extension}.svg`);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else {
                    iziToast.error({
                        message: 'This type of file is not allowed',
                        position: "topRight"
                    });
                }
            }
        }

        $(document).ready(function(){

            $(document).on('change','.up', function(){
                var id = $(this).attr('id'); /* gets the filepath and filename from the input */
                var profilePicValue = $(this).val();
                var fileNameStart = profilePicValue.lastIndexOf('\\'); /* finds the end of the filepath */
                profilePicValue = profilePicValue.substr(fileNameStart + 1).substring(0,20); /* isolates the filename */
                if (profilePicValue != '') {
                    $(this).closest('.fileUpload').find('.upl').html(profilePicValue); /* changes the label text */
                }
            });
        });
  </script>

@endpush

