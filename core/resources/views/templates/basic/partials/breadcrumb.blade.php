@php
    $breadcrumbContent = getContent('breadcrumb.content',true);
@endphp

<section class="inner-page-hero bg_img" style="background-image: url({{ getImage('assets/images/frontend/breadcrumb/'. @$breadcrumbContent->data_values->image,'1920x1080') }});">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
          <h2 class="page-title">{{__($page_title)}}</h2>
          <ul class="page-list justify-content-center">
          </ul>
        </div>
      </div>
    </div>
</section>

