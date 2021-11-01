@extends($activeTemplate.'layouts.frontend')

@section('content')
@include($activeTemplate.'partials.breadcrumb')

<section class="pt-100 pb-100">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="cotent-wrapper">
              @php
                  echo __(@$policy->data_values->details);
              @endphp
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
