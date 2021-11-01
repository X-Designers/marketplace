<div class="user-area">
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <div class="user-wrapper">
            <div class="thumb">
              <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. auth()->user()->image,imagePath()['profile']['user']['size']) }}" alt="@lang('image')">
            </div>
            <div class="content">
              <h4 class="name">{{auth()->user()->getFullnameAttribute()}}</h4>
              <p class="fs-14px">@lang('Member since') {{showDateTime(auth()->user()->created_at,'F, Y')}}</p>
            </div>
          </div>
        </div>
        <div class="col-sm-4 text-end">
          <div class="user-header-status">
            <div class="left">
              <span>@lang('Author Rating')</span>
              <div class="ratings">
                @php echo displayRating(auth()->user()->avg_rating) @endphp
                ({{auth()->user()->total_response}} @lang('Ratings'))
              </div>
            </div>
            <div class="right">
              <span>@lang('Purchased')</span>
              <h4>{{auth()->user()->buy()->where('status',1)->count()}}</h4>
            </div>
          </div>
        </div>
      </div><!-- row end -->
      <div class="row mt-4">
        <div class="col-lg-12">
          <ul class="nav nav-tabs user-nav-tabs">
            <li class="nav-item">
              <a href="{{route('user.home')}}" class="nav-link {{menuActive('user.home')}}">@lang('Dashboard')</a>
            </li>
            <li class="nav-item">
              <a href="{{route('user.product.all')}}" class="nav-link {{menuActive('user.product*')}}">@lang('Your Products')</a>
            </li>
            <li class="nav-item">
              <a href="{{route('user.deposit.history')}}" class="nav-link {{menuActive('user.deposit*')}}">@lang('Deposit')</a>
            </li>
            <li class="nav-item">
              <a href="{{route('user.withdraw.history')}}" class="nav-link {{menuActive('user.withdraw*')}}">@lang('Withdraw')</a>
            </li>
            <li class="nav-item">
              <a href="{{route('user.transaction')}}" class="nav-link {{menuActive('user.transaction*')}}">@lang('Transactions')</a>
            </li>
            <li class="nav-item">
              <a href="{{route('user.sell.log')}}" class="nav-link {{menuActive('user.sell.log')}}">@lang('Sell Logs')</a>
            </li>
            <li class="nav-item">
              <a href="{{route('user.track.sell')}}" class="nav-link {{menuActive('user.track.sell*')}}">@lang('Track Sell')</a>
            </li>
            <li class="nav-item">
              <a href="{{route('ticket')}}" class="nav-link {{menuActive('ticket*')}}">@lang('Support')</a>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </div><!-- user-area end -->
