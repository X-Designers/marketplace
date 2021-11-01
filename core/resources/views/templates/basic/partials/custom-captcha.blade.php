@if(\App\Extension::where('act', 'custom-captcha')->where('status', 1)->first())


    <div class="row align-items-end">
        <div class="col-lg-12 code-field">
            @php echo  getCustomCaptcha() @endphp
        </div>
        <div class="col-lg-12">
            <label class="mt-3">@lang('Captcha code') <sup class="text--danger">*</sup></label>
            <div class="input-group">
                <span class="input-group-text"><i class="las la-code fs-4"></i></span>
                <input type="text" name="captcha" autocomplete="off" placeholder="@lang('Enter the code')" class="form--control">
            </div>
        </div>
    </div>

@endif
