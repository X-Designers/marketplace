<header class="header">
    <div class="header__top">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-8 col-md-6">
            <ul class="header-menu-list justify-content-md-start justify-content-center">
              <li><a href="{{route('home')}}">@lang('Home')</a></li>
              <li><a href="{{route('all.products')}}">@lang('Products')</a></li>
                @foreach($pages as $k => $data)
                    <li>
                        <a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a>
                    </li>
                @endforeach
              <li><a href="{{route('blogs')}}">@lang('Blogs')</a></li>
              <li><a href="{{route('contact')}}">@lang('Contact')</a></li>
            </ul>
          </div>
          <div class="col-lg-4 col-md-6 text-md-end">
            <div class="d-flex flex-wrap align-items-center justify-content-md-end justify-content-center">

                <a href="{{route('carts')}}" class="menu-cart-btn me-3" data-toggle=tooltip title="Tooltip on bottom">

                    <i class="las la-cart-arrow-down"></i>
                    <span class="cart-badge">
                        @php
                            if(auth()->user()){
                                $ordersCount = auth()->user()->myOrder->count();
                            }else{
                                $ordersCount = App\Order::where('order_number',session()->get('order_number'))->count();
                            }
                        @endphp
                        {{$ordersCount}}
                    </span>
                </a>

                @auth
                    <button type="button" class="menu-cart-btn me-3" data-bs-toggle="tooltip" title="Tooltip on bottom">
                        <span class="cart-badge">
                        {{$general->cur_sym}}{{showAmount(auth()->user()->balance)}}
                        </span>
                    </button>
                @endauth
              <ul class="header-menu-list me-3">
                @auth
                    <li>
                        <div class="dropdown mb-1">
                          <button class="btn btn-sm btn--base dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                          {{auth()->user()->username}}
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="{{route('user.home')}}">@lang('Dashboard')</a></li>
                            <li><a class="dropdown-item" href="{{route('user.purchased.product')}}">@lang('Purchase Log')</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.change-password') }}">@lang('Change Password')</a></li>
                            <li><a class="dropdown-item" href="{{route('user.profile-setting')}}">@lang('Profile Settings')</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.twofactor') }}">@lang('2FA Security')</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                          </ul>
                        </div>
                    </li>
                @else
                    <li>
                        <a href="{{ route('user.login') }}"><i class="las la-user"></i> @lang('Sign in')</a>
                    </li>
                    <li>
                        <a href="{{ route('user.register') }}"><i class="las la-user-plus"></i> @lang('Sign up')</a>
                    </li>
                @endauth
              </ul>


              <select name="site-language" class="laguage-select langSel">
                @foreach($language as $item)
                    <option value="{{ __($item->code) }}"  @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="header__bottom">
      <div class="container">
        <nav class="navbar navbar-expand-xl p-0 align-items-center">
          <a class="site-logo site-title" href="{{route('home')}}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('site-logo')"></a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="menu-toggle"></span>
          </button>

          <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
            <ul class="navbar-nav main-menu ms-auto">

                @foreach ($categories as $key => $item)
                    @if($key < 8)
                        <li class="menu_has_children">
                            <a href="javascript:void(0)">{{__($item->name)}}</a>
                            @if (count($item->subCategories) > 0)
                                <ul class="sub-menu">
                                    @foreach ($item->subCategories->where('status',1) as $data)
                                        <li><a href="{{route('subcategory.search',[$data->id,str_slug($data->name)])}}">{{__($data->name)}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @else
                        <li class="menu_has_children">
                            <a href="javascript:void(0)">@lang('More')</a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="javascript:void(0)">{{__($item->name)}}</a>
                                    <ul class="sub-menu">
                                        @foreach ($item->subCategories->where('status',1) as $data)
                                            <li><a href="{{route('subcategory.search',[$data->id,str_slug($data->name)])}}">{{__($data->name)}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>

            <div class="nav-right">
              <button class="header-serch-btn toggle-close"><i class="fa fa-search"></i></button>
              <div class="header-top-search-area">
                <form class="header-search-form" method="GET" action="{{route('product.search')}}">
                  <input type="search" name="search" id="header_search" placeholder="@lang('Search here')...">
                  <button class="header-search-btn" type="submit"><i class="fa fa-search"></i></button>
                </form>
              </div>
            </div>

          </div>
        </nav>
      </div>
    </div><!-- header__bottom end -->
</header>
