@php
    $blogContent = getContent('blog.content',true);
    $blogElements = \App\Frontend::where('data_keys', 'blog.element')->latest()->limit(3)->get();
@endphp


<section class="pt-100 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
            <div class="section-header text-center">
                <h2 class="section-title">{{__(@$blogContent->data_values->heading)}}</h2>
                <p class="mt-3">{{__(@$blogContent->data_values->sub_title)}}</p>
            </div>
            </div>
        </div><!-- row end -->
        <div class="row gy-4 justify-content-center">
            @foreach($blogElements as $item)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                    <div class="post-card">
                        <div class="post-card__thumb">
                            <img src="{{ getImage('assets/images/frontend/blog/'. @$item->data_values->image,'590x300') }}" alt="@lang('image')">
                            <ul class="post-meta">
                                <li><i class="las la-tag"></i> {{__(@$item->data_values->tag)}}</li>
                                <li><i class="las la-calendar"></i> {{showDateTime(@$item->data_values->created_at,'d M, Y')}}</li>
                            </ul>
                        </div>
                        <div class="post-card__content">
                            <h5 class="post-card__title mb-3"><a href="{{ route('blog.details',[$item->id,str_slug(__(@$item->data_values->title))]) }}">{{ str_limit(strip_tags(__(@$item->data_values->title)),50) }}</a></h5>
                            <p>{{ str_limit(strip_tags(__(@$item->data_values->description)),92) }}</p>
                            <a href="{{ route('blog.details',[@$item->id,str_slug(__(@$item->data_values->title))]) }}" class="read-more mt-2">@lang('Read More')</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
