@extends($activeTemplate.'layouts.frontend')

@php
    $faqContent = getContent('faq.content',true);
    $faqElements = \App\Frontend::where('data_keys', 'faq.element')->latest()->get();
@endphp

@section('content')
    @include($activeTemplate.'partials.breadcrumb')
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                @foreach($blogElements as $item)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                        <div class="post-card">
                            <div class="post-card__thumb">
                                <img src="{{ getImage('assets/images/frontend/blog/'. @$item->data_values->image,'590x300') }}" alt="@lang('image')">
                                <ul class="post-meta justify-content-between">
                                    <li><i class="las la-tag"></i> {{__(@$item->data_values->tag)}}</li>
                                    <li><i class="las la-calendar"></i> {{showDateTime(@$item->data_values->created_at,'d M, Y')}}</li>
                                </ul>
                            </div>
                            <div class="post-card__content">
                                <h5 class="post-card__title mb-3"><a href="{{ route('blog.details',[$item->id,str_slug(__(@$item->data_values->title))]) }}">{{ str_limit(strip_tags(__(@$item->data_values->title)),50) }}</a></h5>
                                <p>{{ str_limit(strip_tags(__(@$item->data_values->description)),150) }}</p>
                                <a href="{{ route('blog.details',[@$item->id,str_slug(__(@$item->data_values->title))]) }}" class="read-more mt-2">@lang('Read More')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination--sm justify-content-center mt-4">
                {{$blogElements->links()}}
            </div>
        </div>
    </section>

    <!-- faq section start -->
    <section class="pt-100 pb-100 section--bg">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="section-header text-center">
              <h2 class="section-title">{{__(@$faqContent->data_values->heading)}}</h2>
              <p class="mt-3">{{__(@$faqContent->data_values->sub_title)}}</p>
            </div>
          </div>
        </div><!-- row end -->
        <div class="accordion custom--accordion" id="faqAccordion">
          <div class="row">
            <div class="col-lg-6">
                @foreach ($faqElements as $item)
                    @if ($loop->odd)
                        <div class="accordion-item">
                        <h2 class="accordion-header" id="h-{{$loop->index}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c-{{$loop->index}}" aria-expanded="false" aria-controls="c-{{$loop->index}}">
                                {{__(str_limit(@$item->data_values->question,60))}}
                            </button>
                        </h2>
                        <div id="c-{{$loop->index}}" class="accordion-collapse collapse" aria-labelledby="h-{{$loop->index}}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                            <p>{{__(@$item->data_values->answer)}}</p>
                            </div>
                        </div>
                        </div><!-- accordion-item-->
                    @endif
                @endforeach
            </div>
            <div class="col-lg-6 mt-lg-0 mt-4">
                @foreach ($faqElements as $item)
                    @if ($loop->even)
                        <div class="accordion-item">
                        <h2 class="accordion-header" id="h-{{$loop->index}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c-{{$loop->index}}" aria-expanded="false" aria-controls="c-{{$loop->index}}">
                                {{__(str_limit(@$item->data_values->question,60))}}
                            </button>
                        </h2>
                        <div id="c-{{$loop->index}}" class="accordion-collapse collapse" aria-labelledby="h-{{$loop->index}}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                            <p>{{__(@$item->data_values->answer)}}</p>
                            </div>
                        </div>
                        </div><!-- accordion-item-->
                    @endif
                @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- faq section end -->

@endsection
