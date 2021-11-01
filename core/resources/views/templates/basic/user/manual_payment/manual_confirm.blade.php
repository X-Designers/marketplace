@extends($activeTemplate.'layouts.frontend')
    @section('content')

    <div class="pb-100">
        @include($activeTemplate.'partials.dashboardHeader')

        <div class="dashboard-area pt-50">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card card-deposit ">
                            <div class="card-header bg--base text-center">
                                <h3 class="text-white">{{__($page_title)}}</h3>
                            </div>
                            <div class="card-body  ">
                                <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <p class="text-center mt-2">@lang('You have requested') <b class="text--base">{{ getAmount($data['amount'])  }} {{__($general->cur_text)}}</b> , @lang('Please pay')
                                                <b class="text--base">{{getAmount($data['final_amo']) .' '.$data['method_currency'] }} </b> @lang('for successful payment')
                                            </p>
                                            <h4 class="text-center text--base mb-4">@lang('Please follow the instruction bellow')</h4>

                                            <p class="my-4 text-center">@php echo  $data->gateway->description @endphp</p>
                                        </div>

                                        @if($method->gateway_parameter)

                                            @foreach(json_decode($method->gateway_parameter) as $k => $v)

                                                @if($v->type == "text")
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>
                                                            <input type="text" class="form--control" name="{{$k}}" value="{{old($k)}}" placeholder="{{__($v->field_level)}}">
                                                        </div>
                                                    </div>
                                                @elseif($v->type == "textarea")
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>
                                                                <textarea name="{{$k}}"  class="form--control"  placeholder="{{__($v->field_level)}}" rows="3">{{old($k)}}</textarea>

                                                            </div>
                                                        </div>
                                                @elseif($v->type == "file")
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>{{__($v->field_level)}} @if($v->validation == 'required') <sup class="text--danger">*</sup> @endif</label>
                                                            <div id="uploader" class="it">
                                                              <div class="row uploadDoc">
                                                                <div class="col-xxl-6 col-xl-6">
                                                                  <div class="fileUpload btn btn-orange">
                                                                    <img src="{{asset('assets/images/first.svg')}}" class="icon">
                                                                    <span class="upl fs-12px" id="upload">@lang('Upload document')</span>
                                                                    <input type="file" name="{{$k}}" class="upload up" id="up" onchange="readURL(this);" accept="image/*" />
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn--base w-100">@lang('Pay Now')</button>
                                            </div>
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
