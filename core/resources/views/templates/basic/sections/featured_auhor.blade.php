@php
    $featuredAuthorContent = getContent('featured_auhor.content',true);
    $featuredAuthor = \App\Featured::latest()->first();
@endphp

@if ($featuredAuthor)
    @if ($featuredAuthor->user->status == 1)
        <!-- featured author seciton start -->
        <section class="pt-100 pb-100 bg__img" style="background-image: url({{ asset($activeTemplateTrue.'images/bg3.jpg') }});">
            <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 mb-5">
                <h2 class="section-title mb-4">{{__(@$featuredAuthorContent->data_values->heading)}}</h2>
                <div class="row gy-3 align-items-center">
                    <div class="col-lg-8">
                        <div class="featured-author d-flex flex-wrap align-items-center">
                            <div class="thumb">
                            <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $featuredAuthor->user->image,imagePath()['profile']['user']['size']) }}" alt="image">
                            </div>
                            <div class="content">
                            <h4 class="title">{{$featuredAuthor->username}}</h4>
                            <p>{{@$featuredAuthor->user->address->country}}, @lang('Member since') {{showDateTime($featuredAuthor->user->created_at,'F, Y')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{route('username.search',strtolower($featuredAuthor->user->username))}}" class="btn btn-sm btn--base mt-2">@lang('View author profile')</a>
                    </div>
                </div>
                </div>
                <div class="col-lg-12">
                <div class="row gy-4 justify-content-center">
                    @php
                        $products = \App\Product::where('user_id',$featuredAuthor->user_id)->where('status', 1)->whereHas('user', function ($query) {
                            $query->where('status',1);
                        })->whereHas('category', function ($query) {
                            $query->where('status',1);
                        })->whereHas('subcategory', function ($query) {
                            $query->where('status',1);
                        })->latest()->limit(3)->with(['subcategory','user'])->get()
                    @endphp

                    @foreach ($products as $data)

                        <div class="col-xl-4 col-md-6">
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
                            <a href="{{$data->demo_link}}" class="cart-btn"><i class="las la-eye"></i> @lang('Live Preview')</a>
                            </div>
                            </div>
                        </div><!-- product-card end -->
                        </div>
                    @endforeach

                </div><!-- row end -->
                </div>
            </div>
            </div>
        </section>
        <!-- featured author seciton end -->
    @endif
@endif
