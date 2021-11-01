@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="pb-100">
    <div class="user-area py-4">
        <div class="container">
          <div class="row">
            <div class="col-sm-8">
              <div class="user-wrapper">
                <div class="thumb">
                  <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $user->image,imagePath()['profile']['user']['size']) }}" alt="@lang('image')">
                </div>
                <div class="content">
                  <h4 class="name">{{$user->username}}</h4>
                  <p class="fs-14px">@lang('Member since') {{showDateTime($user->created_at,'F, Y')}}</p>
                </div>
              </div>
            </div>
            <div class="col-sm-4 text-end">
              <div class="user-header-status">
                <div class="left">
                  <span>@lang('Author Rating')</span>
                  <div class="ratings">
                    @php echo displayRating($user->avg_rating) @endphp
                    ({{$user->total_response}} @lang('Ratings'))
                  </div>
                </div>
                <div class="right">
                  <span>@lang('Sales')</span>
                  <h4>{{$totalSell}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="container pt-50">
      <div class="row gy-5">
          <div class="col-lg-8">
              <div class="portfolio-single">
                  <div class="portforlio-single-thumb">
                      <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $user->cover_image,imagePath()['profile']['cover']['size']) }}" alt="@lang('image')">
                  </div>
                  <div class="portforlio-single-content">
                        @php echo $user->description; @endphp
                  </div>
              </div>
          </div>
          <div class="col-lg-4">
            <div class="product-widget">
                <div class="author-widget">
                  <div class="thumb">
                    <img src="{{ getImage(imagePath()['level']['path'].'/'. $user->levell->image,imagePath()['level']['size'])}}" alt="@lang('image')">
                  </div>
                  <div class="content">
                    <h5 class="author-name"><a href="#0">{{$user->levell->name}}</a></h5>
                    <span class="txt"><a href="{{route('author.products',$user->username)}}">@lang('Total Products') : {{$totalProduct}}</a></span>
                  </div>
                </div>
                <ul class="author-badge-list w-100 border-top mt-3 pt-3">
                    @foreach ($levels as $key => $item)
                        @if ($key+1 <= $user->level_id)
                            <li>
                                <img src="{{ getImage(imagePath()['level']['path'].'/'. $item->image,imagePath()['level']['size'])}}" alt="@lang('image')">
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="product-widget mt-4">
                <h5 class="title border-bottom mb-3 pb-3">@lang('Email to') {{$user->username}}</h5>
                @auth
                    @if ($user->id != auth()->user()->id)
                        <form action="{{route('user.email.author')}}" method="POST">
                            @csrf
                            <input type="hidden" name="author" value="{{$user->username}}">
                            <div class="form-group mb-3">
                                <input type="text" class="form-control form--control" value="{{auth()->user()->email}}" disabled>
                            </div>
                            <div class="form-group mb-3">
                                <textarea name="message" class="form-control form--control border" placeholder="@lang('Your Message')" required>{{old('message')}}</textarea>
                            </div>
                            <button type="submit" class="btn btn--base w-100">@lang('Send Email')</button>
                        </form>
                    @else
                        @lang('This is your own profile')
                    @endif
                @else
                    @lang('Please') <a href="{{ route('user.login') }}" class="text--base">@lang('sign in')</a> @lang('to contact this author').
                @endauth
            </div>
          </div>
      </div>
    </div>
</section>
@endsection
