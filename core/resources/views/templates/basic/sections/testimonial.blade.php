@php
    $testimonialContent = getContent('testimonial.content',true);
    $testimonialElements = getContent('testimonial.element',false);
@endphp


<section class="pt-100 pb-100 bg_img" style="background-image: url({{ asset($activeTemplateTrue.'/images/bg2.jpg') }});">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="section-header text-center">
            <h2 class="section-title">{{__(@$testimonialContent->data_values->heading)}}</h2>
            <p class="mt-3">{{__(@$testimonialContent->data_values->sub_title)}}</p>
          </div>
        </div>
      </div>
      <div class="testimonial-slider">
          @foreach($testimonialElements as $item)
            <div class="single-slide">
                <div class="testimonial-card">
                  <div class="testimonial-card__top d-flex flex-wrap align-items-center">
                    <div class="client-thumb">
                      <img src="{{ getImage('assets/images/frontend/testimonial/'. @$item->data_values->image,'394x452') }}" alt="@lang('image')">
                    </div>
                    <div class="content">
                      <h6 class="name">{{__(@$item->data_values->name)}}</h6>
                      <span class="designation fs-14px text--base">{{__(@$item->data_values->designation)}}</span>
                    </div>
                  </div>
                  <p class="mt-3">{{__(@$item->data_values->quote)}}</p>
                </div>
            </div>
        @endforeach
      </div>
    </div>
  </section>
