@extends($activeTemplate.'layouts.frontend')

@section('content')
    <section class="pt-50 pb-100">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-12">
                <form class="single-search-form pb-3" method="GET" action="{{route('product.search')}}">
                    <input type="text" name="search" value="{{ request()->search??null }}" class="form--control" placeholder="@lang('Search here')...">
                    <button type="submit" class="btn btn--base single-search-btn">@lang('Search')</button>
                </form>
                <p class="fs-14px mt-1"> @lang('Search Result : ')<b>{{count($products)}}</b> @lang('Items Found')</p>
                <hr>
                </div>
            </div><!-- row end --->


            <div class="row">
                <div class="col-lg-3 mb-lg-0 mb-3">
                    <button class="action-sidebar-open"><i class="las la-sliders-h"></i> @lang('Filter')</button>
                    <form action="" id="ms-form">
                        <div class="action-sidebar">
                            <button class="action-sidebar-close"><i class="las la-times"></i></button>
                            <div class="action-widget top-widget">
                                <h4 class="action-widget__title">@lang('Filter & Refine')</h4>
                                <!-- <hr> -->
                            </div><!-- action-widget end -->

                            <div class="action-widget mt-4">
                                <h6 class="action-widget__title">@lang('Categories')</h6>
                                <div class="action-widget__body">

                                    @foreach ($categoryForSearchPage as $item)
                                        <div class="form-check custom--checkbox">
                                            <input class="form-check-input filter-by-category" name="categories" type="checkbox" value="{{$item->id}}" id="chekbox-{{$loop->index}}">
                                            <label class="form-check-label" for="chekbox-{{$loop->index}}">
                                                {{__($item->name)}}
                                            </label>
                                        </div><!-- form-check end -->
                                    @endforeach

                                </div>
                            </div><!-- action-widget css end -->

                            <div class="action-widget mt-4">
                                <h6 class="action-widget__title">@lang('Tags')</h6>
                                <div class="action-widget__body scroll--active">
                                    @foreach ($tags as $data)
                                        <div class="form-check custom--checkbox">
                                            <input class="form-check-input filter-by-tag" name="tags" type="checkbox" value="{{$data}}" id="chekbox-tag-{{$loop->index}}">
                                            <label class="form-check-label" for="chekbox-tag-{{$loop->index}}">
                                                {{__($data)}}
                                            </label>
                                        </div><!-- form-check end -->
                                    @endforeach
                                </div>
                            </div><!-- action-widget css end -->
                            <div class="action-widget mt-4">
                                <h6 class="action-widget__title">@lang('By price')</h6>
                                <div class="action-widget__body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="widget-range-area">
                                                <div id="slider-range"></div>
                                                <div class="price-range">
                                                    <label for="amount">@lang('Price') :</label>
                                                    <input type="text" id="amount" readonly>
                                                    <input type="hidden" name="min_price" value="{{$min}}">
                                                    <input type="hidden" name="max_price" value="{{$max}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- action-widget end -->
                        </div><!-- action-sidebar end -->
                    </form>
                </div>
                <div class="col-lg-9">

                    <div class="main-content">
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
                                                    <li class="product-sale-amount"><i class="las la-shopping-cart text--base"></i> <span class="text--base">{{$item->total_sell}}</span> @lang('Sales')</li>

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
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-12">
                            <ul class="pagination justify-content-end">
                                {{$products->links()}}
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@push('script-lib')
    <script src="{{asset($activeTemplateTrue.'js/jquery-ui.min.js')}}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        (function ($) {

            // grid & list view js
            const gridBtn = $('.grid-view-btn');
            const listBtn = $('.list-view-btn');

            const gridView = $('.grid-view');
            const listView = $('.list-view');


            gridBtn.on('click', function(){
                // button active class check
                if($(this).hasClass('active')){
                    return true
                } else {
                    $(this).addClass('active');
                    $(this).siblings('.list-view-btn').removeClass('active');
                }
                // grid & list view check
                if($(document).find('.main-content .card-view-area').hasClass('list-view')) {
                    $(document).find('.main-content .card-view-area').removeClass('list-view');
                    $(document).find('.main-content .card-view-area').addClass('grid-view');
                }
            })

            listBtn.on('click', function(){
                if($(this).hasClass('active')){
                    return true
                } else {
                    $(this).addClass('active');
                    $(this).siblings('.grid-view-btn').removeClass('active');
                }
                // grid & list view check
                if($(document).find('.main-content .card-view-area').hasClass('grid-view')) {
                    $(document).find('.main-content .card-view-area').removeClass('grid-view');
                    $(document).find('.main-content .card-view-area').addClass('list-view');
                }
            })

            let min = {{$min}};
            let max = {{$max}};



            $("#slider-range").slider({
                range: true,
                min: {{$min}},
                max: {{$max}},
                values: [ {{$min}}, {{$max}} ],

                slide: function( event, ui ) {

                    $( "#amount" ).val( "{{$general->cur_sym}}" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                    $('input[name=min_price]').val(ui.values[ 0 ]);
                    $('input[name=max_price]').val(ui.values[ 1 ]);

                },
                change: function(){
                    var categories   = [];
                    var tags         = [];


                    min = $('input[name="min_price"]').val();
                    max = $('input[name="max_price"]').val();

                    getFilteredData(min, max, categories, tags);
                }
            });

            $( "#amount" ).val("{{$general->cur_sym}}" + {{$min}} + " - {{$general->cur_sym}}" + {{$max}});

            $("input[type='checkbox'][name='categories']").on('click', function(){
                var categories   = [];
                var tags         = [];


                $('.filter-by-category:checked').each(function() {
                    if(!categories.includes(parseInt($(this).val()))){
                        categories.push(parseInt($(this).val()));
                    }
                });

                getFilteredData(min, max, categories, tags)
            });



            $("input[type='checkbox'][name='tags']").on('click', function(){
                var categories   = [];
                var tags         = [];


                $('.filter-by-tag:checked').each(function() {
                    if(!tags.includes($(this).val())){
                        tags.push($(this).val());
                    }
                });
                getFilteredData(min, max, categories, tags)

            });



            function getFilteredData(min, max, categories, tags){

                $.ajax({
                    type: "get",
                    url: "{{ route('product.filtered') }}",
                    data:{
                        "min": min,
                        "max": max,
                        "categories": categories,
                        "tags": tags,
                        "search": "{{ request()->search }}",
                    },
                    dataType: "json",
                    success: function (response) {
                        if(response.html){
                            $('.main-content').html(response.html);
                        }

                        if(response.error){
                            notify('error', response.error);
                        }
                    }
                });
            }

        })(jQuery);

    </script>
@endpush
