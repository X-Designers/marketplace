<div class="row gy-4 card-view-area list-view">
    @forelse ($products as $item)
        <div class="col-md-6 card-view">
            <div class="product-card">
                @if($item->featured == 1)
                    <span class="tending-badge"><i class="las la-bolt"></i></span>
                @endif
                <div class="product-card__thumb">
                <a href="{{ route('product.details',[str_slug(__($item->name)),$item->id]) }}"><img src="{{ getImage(imagePath()['p_image']['path'].'/thumb_'. $item->image,imagePath()['p_image']['size'])}}" alt="@lang('image')"></a>
                </div>
                <div class="product-card__content">
                    <h6 class="product-title mb-1"><a href="{{ route('product.details',[str_slug(__($item->name)),$item->id]) }}">{{str_limit(__($item->name),32)}}</a></h6>
                    <p>@lang('by') <a href="{{route('username.search',strtolower($item->user->username))}}">{{$item->user->username}}</a> @lang('in') <a href="{{route('subcategory.search',[$item->subcategory->id,str_slug($item->subcategory->name)])}}">{{__($item->subcategory->name)}}</a></p>
                    <div class="product-card__meta">
                        <div class="left">
                        <p class="mb-1">@lang('Last Updated') - {{showDateTime($item->updated_at,'d M Y')}}</p>

                        <ul class="meta-list">
                            <li><i class="las la-download"></i> {{$item->total_sell}} @lang('Sales')</li>

                            <li class="ratings">
                                @php echo displayRating($item->avg_rating) @endphp
                                ({{$item->total_response}})
                            </li>
                        </ul>
                        </div>
                        <div class="right">
                        <h5 class="product-price mb-2 text-center">{{__($general->cur_sym)}}{{getAmount($item->regular_price)}}</h5>
                        <a href="{{ route('product.details',[str_slug(__($item->name)),$item->id]) }}" class="cart-btn"><i class="las la-shopping-cart"></i> @lang('Purchase')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-xl-12 col-md-12 card-view">
            <div class="product-card">
                <h6 class="product-title mb-1">{{__($empty_message)}}</h6>
            </div>
        </div>
    @endforelse

</div><!-- row end -->

