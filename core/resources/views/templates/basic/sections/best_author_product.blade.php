@php
    $bestAuthorContent = getContent('best_author_product.content',true);

    $bestAuthorProducts = \App\Product::where('status', 1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->whereHas('category', function ($query) {
            $query->where('status',1);
        })->whereHas('subcategory', function ($query) {
            $query->where('status',1);
        })->selectRaw('products.*, (avg_rating*total_sell) as point')
        ->orderBy('point', 'desc')
        ->with(['subcategory','user'])->limit(12)->get();
@endphp

<section class="pt-100 pb-100 px-xxl-5">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6 wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.3s">
            <div class="box-header text-lg-start text-center">
                <h2 class="section-title">{{__(@$bestAuthorContent->data_values->heading)}}</h2>
                <p class="mt-2">{{__(@$bestAuthorContent->data_values->sub_title)}}</p>
            </div>
            </div>
            <div class="col-lg-4 text-lg-end text-center">
            <a href="{{route('best.author.products')}}" class="btn btn--base2 mt-4">@lang('View All Items')</a>
            </div>
        </div>
        <div class="product-two-slider custom-arrow mt-5">
            @foreach ($bestAuthorProducts as $data)

                <div class="single-slide">
                    <div class="product-card style--three v2">
                        @if ($data->featured == 1)
                            <span class="tending-badge"><i class="las la-bolt"></i></span>
                        @endif
                        <div class="product-card__thumb">
                        <a href="{{ route('product.details',[str_slug(__($data->name)),$data->id]) }}"><img src="{{ getImage(imagePath()['p_image']['path'].'/thumb_'. $data->image,imagePath()['p_image']['size'])}}" alt="@lang('image')"></a>
                        </div>
                        <div class="product-card__content">
                            <p class="mb-2">@lang('by') <a href="{{route('username.search',strtolower($data->user->username))}}" class="text--base">{{__($data->user->username)}}</a> @lang('in') <a href="{{route('subcategory.search',[$data->subcategory->id,str_slug($data->subcategory->name)])}}" class="text--base">{{__($data->subcategory->name)}}</a></p>
                            <h6 class="product-title mb-1"><a href="{{ route('product.details',[str_slug(__($data->name)),$data->id]) }}">{{str_limit(__($data->name),32)}}</a></h6>
                            <div class="product-card__meta align-items-center">
                            <div class="left">
                                <ul class="meta-list">
                                    <li class="product-sale-amount"><i class="las la-shopping-cart text--base"></i> <span class="text--base">{{$data->total_sell}}</span> @lang('Sales')</li>
                                    <li class="ratings">
                                        @php echo displayRating($data->avg_rating) @endphp
                                        ({{$data->total_response}})
                                    </li>
                                </ul>
                            </div>
                            <div class="right">
                                <h5 class="product-price">{{__($general->cur_sym)}}{{getAmount($data->regular_price)}}</h5>
                            </div>
                            </div>
                            <div class="product-card__btn-area">
                            <a href="{{ route('product.details',[str_slug(__($data->name)),$data->id]) }}" class="cart-btn style--two"><i class="las la-shopping-cart"></i> @lang('Details')</a>
                            <a href="{{ route('product.details',[str_slug(__($data->name)),$data->id]) }}" class="cart-btn"><i class="las la-eye"></i> @lang('Live Preview')</a>
                            </div>
                        </div>
                    </div><!-- product-card end -->
                </div><!-- single-slide end -->

            @endforeach

        </div>
    </div>
</section>
