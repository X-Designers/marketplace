@extends($activeTemplate.'layouts.frontend')

@section('content')
@include($activeTemplate.'partials.breadcrumb')
    @php echo fbcomment() @endphp

    <section class="blog-details-section pt-120 pb-120">
        <div class="container">
          <div class="row">
            <div class="col-lg-8">
              <div class="blog-details-wrapper">
                <div class="blog-details__thumb">
                  <img src="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'590x300') }}" alt="@lang('image')">
                  <div class="post__date">
                    <span class="date">{{showDateTime(@$blog->data_values->created_at,'d')}}</span>
                    <span class="month">{{showDateTime(@$blog->data_values->created_at,'M')}}</span>
                  </div>
                </div><!-- blog-details__thumb end -->
                <div class="blog-details__content">
                  <h4 class="blog-details__title mb-3">{{__(@$blog->data_values->title)}}</h4>
                  @php echo __(@$blog->data_values->description) @endphp
                </div><!-- blog-details__content end -->
                <div class="blog-details__footer">
                  <h4 class="caption">@lang('Share This Post')</h4>

                  <ul class="social__links">
                    <li><a href="http://www.facebook.com/sharer.php?u={{urlencode(url()->current())}}&p[title]={{str_slug(@$blog->data_values->title)}}"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="http://twitter.com/share?text={{str_slug(@$blog->data_values->title)}}&url={{urlencode(url()->current()) }}"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="http://pinterest.com/pin/create/button/?url={{urlencode(url()->current()) }}&description={{str_slug(@$blog->data_values->title)}}"><i class="fab fa-pinterest-p"></i></a></li>
                    <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{urlencode(url()->current()) }}&title={{str_slug(@$blog->data_values->title)}}"><i class="fab fa-linkedin-in"></i></a></li>
                  </ul>
                </div>
              </div>

                <div class="fb-comments w-100" data-href="{{ url()->current() }}" data-numposts="5"></div>
          
            </div>
            <div class="col-lg-4">
              <div class="sidebar">
                <div class="widget search--widget p-0 border-0">
                  <form class="search-form" method="GET" action="{{route('product.search')}}">
                    <input type="search" name="search" id="search__field" class="form--control" placeholder="@lang('Search here')">
                    <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
                  </form>
                </div>
                <div class="widget">
                  <h5 class="widget__title">@lang('Categories')</h5>
                  <ul class="categories__list">
                    @foreach($categories as $item)
                        <li class="categories__item"><a href="{{route('category.search',[$item->id,str_slug($item->name)])}}">{{__($item->name)}} <span class="rating-amount">{{$item->products->count()}}</span></a></li>
                    @endforeach
                  </ul>
                </div>
                <div class="widget">
                  <h5 class="widget__title">@lang('Recent Post')</h5>
                  <ul class="small-post-list">
                    @foreach($recentBlogs as $item)
                        <li class="small-post">
                        <div class="small-post__thumb"><img src="{{ getImage('assets/images/frontend/blog/'.@$item->data_values->image,'590x300') }}" alt="image"></div>
                        <div class="small-post__content">
                            <h5 class="post__title"><a href="{{ route('blog.details',[@$item->id,str_slug(__(@$item->data_values->title))]) }}">{{ str_limit(strip_tags(__(@$item->data_values->title)),25) }}</a></h5>
                            <p class="mt-1 fs-14px">{{showDateTime(@$item->data_values->created_at,'d M, Y')}}</p>
                        </div>
                        </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
@endsection


@push('shareImage')
    {{--<!-- Google / Search Engine Tags -->--}}
    <meta itemprop="name" content="{{ __(@$blog->data_values->title) }}">
    <meta itemprop="description" content="{{ strip_tags(__(@$blog->data_values->description)) }}">
    <meta itemprop="image" content="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'590x300') }}">

    {{--<!-- Facebook Meta Tags -->--}}
    <meta property="og:image" content="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'590x300') }}"/>
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ __(@$blog->data_values->title) }}">
    <meta property="og:description" content="{{ strip_tags(__(@$blog->data_values->description)) }}">
    <meta property="og:image:type" content="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'590x300') }}" />
    <meta property="og:image:width" content="590" />
    <meta property="og:image:height" content="300" />
    <meta property="og:url" content="{{ url()->current() }}">
@endpush
