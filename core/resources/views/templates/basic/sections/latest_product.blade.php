@php
    $latestProductContent = getContent('latest_product.content',true);
    $latestProducts = \App\Product::where('status',1)->whereHas('user', function ($query) {
                            $query->where('status',1);
                        })->whereHas('category', function ($query) {
                            $query->where('status',1);
                        })->whereHas('subcategory', function ($query) {
                            $query->where('status',1);
                        })->with(['subcategory','user'])->limit(8)->latest()->get();

    $categoyData = \App\Category::where('status',1)->with(['products'=>function($q){
                        $q->where('status',1)->whereHas('user', function ($query) {
                                        $query->where('status',1);
                                    })->whereHas('category', function ($query) {
                                        $query->where('status',1);
                                    })->whereHas('subcategory', function ($query) {
                                        $query->where('status',1);
                                    })->limit(8);
                    },'products.subcategory','products.user'])->latest()->get();

@endphp
<section class="pt-100 pb-100 section--bg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="section-header text-center">
            <h2 class="section-title">{{__(@$latestProductContent->data_values->heading)}}</h2>
            <p class="mt-2">{{__(@$latestProductContent->data_values->sub_title)}}</p>
          </div>
        </div>
      </div>

      <div class="row justify-content-center mb-50">
        <div class="col-lg-12">
          <ul class="nav nav-tabs custom--nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all-tab" type="button" role="tab" >@lang('All Categoires')</button>
            </li>

            @foreach ($categoyData as $item)
                <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#{{str_replace(' ','_',strtolower($item->name))}}" type="button" role="tab">{{__($item->name)}}</button>
                </li>
            @endforeach

          </ul>
        </div>
      </div>

      <div class="tab-content mt-5">

        <div class="tab-pane fade show active" id="all-tab" role="tabpanel">
          <div class="row gy-4 justify-content-center">

            @forelse($latestProducts as $item)

                <div class="col-xl-3 col-md-6">
                    <div class="product-card style--three p-0">
                        @if($item->featured == 1)
                            <span class="tending-badge"><i class="las la-bolt"></i></span>
                        @endif
                        <div class="product-card__thumb">
                            <a href="{{ route('product.details',[str_slug(__($item->name)),$item->id]) }}"><img src="{{ getImage(imagePath()['p_image']['path'].'/thumb_'. $item->image,imagePath()['p_image']['size'])}}" alt="@lang('product-image')"></a>
                        </div>

                        <div class="product-card__content bg-white">
                          <p class="mb-1">@lang('by') <a href="{{route('username.search',strtolower($item->user->username))}}" class="text--base">{{__($item->user->username)}}</a> @lang('in') <a href="{{route('subcategory.search',[$item->subcategory->id,str_slug($item->subcategory->name)])}}" class="text--base">{{__($item->subcategory->name)}}</a></p>
                            <h6 class="product-title mb-1"><a href="{{ route('product.details',[str_slug(__($item->name)),$item->id]) }}">{{str_limit(__($item->name),32)}}</a></h6>
                            <div class="product-card__meta">
                                <div class="left">
                                <h5 class="product-price mb-3">{{__($general->cur_sym)}}{{getAmount($item->regular_price)}}</h5>
                                <ul class="meta-list">
                                <li class="product-sale-amount"><i class="las la-shopping-cart text--base"></i> <span class="text--base">{{$item->total_sell}}</span> @lang('Sales')</li>
                                </ul>
                                </div>
                                <div class="right">
                                    <a href="{{ route('product.details',[str_slug(__($item->name)),$item->id]) }}" class="cart-btn"><i class="las la-shopping-cart"></i> @lang('Purchase')</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- product-card end -->
                </div>
            @empty
              <p class="text-center">@lang('No products found')</p>
            @endforelse
          </div><!-- row end -->
        </div>

        @foreach ($categoyData as $item)
            <div class="tab-pane fade" id="{{str_replace(' ','_',strtolower($item->name))}}" role="tabpanel">
                <div class="row gy-4 justify-content-center">

                    @forelse($item->products as $data)

                            <div class="col-xl-3 col-md-6">
                                <div class="product-card style--three p-0">
                                    <div class="product-card__thumb">
                                        <a href="{{ route('product.details',[str_slug(__($data->name)),$data->id]) }}"><img src="{{ getImage(imagePath()['p_image']['path'].'/thumb_'. $data->image,imagePath()['p_image']['size'])}}" alt="@lang('product-image')"></a>
                                    </div>
                                    <div class="product-card__content bg-white">
                                        <h6 class="product-title mb-1"><a href="{{ route('product.details',[str_slug(__($data->name)),$data->id]) }}">{{str_limit(__($data->name),32)}}</a></h6>
                                        <p>@lang('by') <a href="{{route('username.search',strtolower($data->user->username))}}">{{$data->user->username}}</a> @lang('in') <a href="{{route('subcategory.search',[$data->subcategory->id,str_slug($data->subcategory->name)])}}">{{__($data->subcategory->name)}}</a></p>

                                        <div class="product-card__meta">
                                            <div class="left">
                                                <h5 class="product-price mb-2">{{__($general->cur_sym)}}{{getAmount($data->regular_price)}}</h5>
                                                <ul class="meta-list">
                                                    <li><i class="las la-download"></i> {{$data->total_sell}} @lang('Sales')</li>
                                                </ul>
                                            </div>
                                            <div class="right">
                                                <a href="{{ route('product.details',[str_slug(__($data->name)),$data->id]) }}" class="cart-btn"><i class="las la-shopping-cart"></i> @lang('Buy Now')</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    @empty
                      <p class="text-center">@lang('No products found')</p>
                    @endforelse
                </div><!-- row end -->
            </div>
        @endforeach
      </div>
      <div class="text-center mt-5">
        <a href="{{route('all.products')}}" class="btn btn--base">@lang('View More New Items')</a>
      </div>
    </div>
</section>
