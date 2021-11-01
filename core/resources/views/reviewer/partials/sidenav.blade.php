<div class="sidebar capsule--rounded bg_img overlay--dark"
     data-background="{{asset('assets/reviewer/images/sidebar/2.jpg')}}">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{route('reviewer.dashboard')}}" class="sidebar__main-logo"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('image')"></a>
            <a href="{{route('reviewer.dashboard')}}" class="sidebar__logo-shape"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}" alt="@lang('image')"></a>
            <button type="button" class="navbar__expand"></button>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{menuActive('reviewer.dashboard')}}">
                    <a href="{{route('reviewer.dashboard')}}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('reviewer.product*',3)}}">
                        <i class="menu-icon lab la-product-hunt"></i>
                        <span class="menu-title">@lang('Manage Product') </span>
                        @if($pending_product_count > 0 || $soft_product_count > 0 || $hard_product_count > 0 || $update_pending_product_count > 0 || $resubmit_product_count > 0)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('reviewer.product*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('reviewer.product.pending')}}">
                                <a href="{{route('reviewer.product.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending')</span>
                                    @if($pending_product_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$pending_product_count}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('reviewer.product.approved')}}">
                                <a href="{{route('reviewer.product.approved')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('reviewer.product.softrejected')}}">
                                <a href="{{route('reviewer.product.softrejected')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Soft Rejected')</span>
                                    @if($soft_product_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$soft_product_count}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('reviewer.product.hardrejected')}}">
                                <a href="{{route('reviewer.product.hardrejected')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Hard Rejected')</span>
                                    @if($hard_product_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$hard_product_count}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('reviewer.product.resubmit*')}}">
                                <a href="{{route('reviewer.product.resubmit')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Resubmit Pending')</span>
                                    @if($resubmit_product_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$resubmit_product_count}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('reviewer.product.update.pending')}}">
                                <a href="{{route('reviewer.product.update.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Update Pending')</span>
                                    @if($update_pending_product_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$update_pending_product_count}}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item {{menuActive('reviewer.twofactor*')}}">
                    <a href="{{ route('reviewer.twofactor') }}" class="nav-link ">
                        <i class="menu-icon las la-shield-alt"></i>
                        <span class="menu-title">@lang('2FA Security')</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
