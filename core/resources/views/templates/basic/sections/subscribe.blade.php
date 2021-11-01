@php
    $subscribeContent = getContent('subscribe.content',true);
@endphp

<!-- subscribe section start -->
<!-- bg_img" style="background-image: url({{ getImage('assets/images/frontend/subscribe/'. @$subscribeContent->data_values->image,'1920x761') }}); -->
<section class="subscribe-section">
  <div class="el"><img src="{{ asset($activeTemplateTrue.'images/bg-el.png') }}" alt="image"></div>
    <div class="container">
      <div class="row align-items-center justify-content-between gy-4">
        <div class="col-lg-5 text-lg-start text-center">
          <h3 class="text-white">{{__(@$subscribeContent->data_values->heading)}}</h3>
          <!-- <p class="text-white mt-3">{{__(@$subscribeContent->data_values->sub_heading)}}</p> -->
        </div>
        <div class="col-lg-6">
          <form class="subscribe-form">
            <div class="custom-icon-field">
              <i class="las la-envelope"></i>
              <input type="email" name="email" id="subscriber" class="form--control" placeholder="@lang('Enter a valid email address')" required>
            </div>
            <button type="button" class="subs">Subscribe <i class="lab la-telegram-plane"></i></button>
          </form>
        </div>
      </div>
    </div>
</section>
  <!-- subscribe section end -->

@push('script')
    <script>

        'use strict';
        $('.subs').on('click',function () {

            var email = $('#subscriber').val();
            var csrf = '{{csrf_token()}}'

            var url = "{{ route('subscriber.store') }}";
            var data = {email:email, _token:csrf};

            $.post(url, data,function(response){

                if(response.success){
                    notify('success', response.success);
                    $('#subscriber').val('');
                }else{
                    notify('error', response.error);
                }
            });

        });

    </script>

@endpush
