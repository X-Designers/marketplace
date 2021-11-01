@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="pt-120 pb-120">
        <div class="container">
          <div class="row gy-4 justify-content-center">
            @forelse($products as $data)
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        @if ($data->featured == 1)
                            <span class="tending-badge"><i class="las la-bolt"></i></span>
                        @endif
                        <div class="product-card__thumb">
                            <a href="{{ route('product.details',[str_slug(__($data->name)),$data->id]) }}"><img src="{{ getImage(imagePath()['p_image']['path'].'/thumb_'. $data->image,imagePath()['p_image']['size'])}}" alt="@lang('product-image')"></a>
                        </div>
                        <div class="product-card__content">
                            <h6 class="product-title mb-1"><a href="{{ route('product.details',[str_slug(__($data->name)),$data->id]) }}">{{str_limit(__($data->name),32)}}</a></h6>
                            <p>@lang('by') <a href="{{route('username.search',strtolower($data->user->username))}}">{{$data->user->username}}</a> @lang('in') <a href="{{route('subcategory.search',[$data->subcategory->id,str_slug($data->subcategory->name)])}}">{{__($data->subcategory->name)}}</a></p>

                            <div class="product-card__meta">
                                <div class="left">
                                    <h5 class="product-price mb-2">{{__($general->cur_sym)}}{{getAmount($data->regular_price)}}</h5>
                                    <ul class="meta-list">
                                        <li><i class="las la-download"></i> {{$data->total_sell}} @lang('Sales')</li>
                                        <li class="ratings">
                                            @php echo displayRating($data->avg_rating) @endphp
                                            ({{$data->total_response}})
                                        </li>
                                    </ul>
                                </div>
                                <div class="right">
                                    <a href="{{ route('product.details',[str_slug(__($data->name)),$data->id]) }}" class="cart-btn"><i class="las la-shopping-cart"></i> @lang('Purchase')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">@lang('No products found')</p>
            @endforelse

          </div><!-- row end -->
          <div class="pagination--sm justify-content-center pt-120">
            {{$products->links()}}
        </div>
        </div>
    </section>


@endsection
