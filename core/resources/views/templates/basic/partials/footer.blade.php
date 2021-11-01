@php
    $socialIconElements = getContent('social_icon.element',false);
    $policyElements = getContent('policy.element',false);
    $footerContent = getContent('footer.content',true);
    $totalSold = \App\Sell::Where('status',1)->count();
    $totalEarning = \App\Sell::Where('status',1)->sum('product_price');
@endphp

<footer class="footer-section">
  <div class="overlay-shape"><img src="{{ getImage('assets/images/frontend/footer/'. @$footerContent->data_values->image,'1920x815') }}" alt="@lang('image')"></div>
    <div class="footer-top">
      <div class="container">
        <div class="footer-top-info-wrapper">
          <div class="row mb-30 align-items-center">
            <div class="col-lg-2 mb-lg-0 mb-5 text-lg-left text-center header">
              <a href="{{route('home')}}" class="footer-logo site-logo"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('site-logo')"></a>
            </div>
            <div class="col-lg-7 col-md-7">
              <div class="row justify-content-center gy-4">
                <div class="col-xl-4 col-sm-6 footer-overview-item text-center">
                  <h3 class="text-white amount-number">{{$totalSold}}</h3>
                  <p class="text-white">@lang('Total Products Sold')</p>
                </div><!-- footer-overview-item end -->
                <div class="col-xl-4 col-sm-6 footer-overview-item text-center">
                  <h3 class="text-white amount-number">{{$general->cur_sym}}{{getAmount($totalEarning)}}</h3>
                  <p class="text-white">@lang('Total Earnings')</p>
                </div><!-- footer-overview-item end -->
              </div>
            </div>
            <div class="col-lg-3 col-md-5 mt-md-0 mt-4">
              <div class="text-md-end text-center">
                <a href="{{route('user.register')}}" class="btn btn--base">@lang('Join Now')</a>
              </div>
            </div>
          </div><!-- row end -->
        </div><!-- footer-top-info-wrapper end -->

        <div class="row gy-5 justify-content-between">
            @foreach ($categories->take(5) as $item)
                <div class="col-lg-2 col-md-3 col-6">
                    <div class="footer-widget">
                    <h4 class="footer-widget__title">{{__($item->name)}}</h4>
                    <ul class="short-link-list">
                        @foreach ($item->subCategories->take(6) as $key=> $data)
                            <li><a href="{{route('subcategory.search',[$data->id,str_slug($data->name)])}}">{{__($data->name)}}</a></li>
                        @endforeach
                    </ul>
                    </div><!-- footer-widget end -->
                </div>
            @endforeach
          <div class="col-lg-2 col-md-3 col-6">
            <div class="footer-widget">
              <h3 class="footer-widget__title">@lang('Company Policy')</h3>
              <ul class="short-link-list">
                  @foreach ($policyElements as $item)
                    <li><a href="{{route('policy',[$item->id,str_slug($item->data_values->heading)])}}">{{__(@$item->data_values->heading)}}</a></li>
                  @endforeach
              </ul>
            </div><!-- footer-widget end -->
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-6 text-md-start text-center">
            <p>{{__(@$footerContent->data_values->copyright)}}</p>
          </div>
          <div class="col-lg-4 col-md-6 mt-md-0 mt-3">
            <ul class="link-list justify-content-md-end justify-content-center">
                @foreach ($socialIconElements as $item)
                    <li><a href="{{@$item->data_values->url}}">@php echo @$item->data_values->social_icon @endphp</a></li>
                @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
</footer>
