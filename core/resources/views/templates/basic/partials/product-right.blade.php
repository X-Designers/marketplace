
            <div class="col-lg-4 ps-lg-4 mt-lg-0 mt-5">
              <div class="product-details-sidebar">
                <div class="product-widget">
                  <form class="product-price-form" action="{{route('addtocart')}}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{Crypt::encrypt($product->id)}}" required>
                    <select id="license-selectBox" class="nice-select w-100" name="license" required>
                      <option value="1" data-resource="{{$product}}" selected>@lang('Regular License')</option>
                      <option value="2" data-resource="{{$product}}">@lang('Extended License')</option>
                    </select>

                    <h5 class="mb-3">@lang('Product Price') <span class="float-end" id="product-price"></span></h5>
                    <p><i class="fas fa-check"></i> @lang('Quality checked by') <b><i>{{$general->sitename}}</i></b></p>
                    <p><i class="fas fa-check"></i> @lang('Future updates')</p>

                    @if($product->support == 1)
                        <p><i class="fas fa-check"></i> @lang('6 months support from') <a href="javascript:void(0)" class="text--base"><i>{{$product->user->username}}</i></a></p>
                        <a href="{{route('support.details')}}" type="button" class="text--base mt-2">@lang('What does support include?')</a>

                        <div class="form-group form-check custom--checkbox mt-3 mb-0">
                            <input type="checkbox" class="form-check-input" id="extendSupport" name="extented_support">
                            <label class="form-check-label" for="extendSupport">@lang('Extend Support for 12 months') <b class="text-dark" id="extendSupportShow"></b></label>
                        </div>

                        @if($product->support_discount)
                            <a href="javascript:void(0)" data-resource="{{$product}}" type="button" class="text--base discount-calc" data-bs-toggle="modal" data-bs-target="#discount-modal"><i class="fas fa-tags"></i> @lang('Get it now and save up to') <span id="support-discount"></span> </a>
                        @endif
                    @elseif($product->support == 0)
                        <p><i class="fas fa-times"></i> @lang('Item support is not offered by the') <a href="javascript:void(0)" class="text--base"><i>{{$product->user->username}}</i></a>, @lang('for these items')</p>
                        <p><i class="fas fa-times"></i> @lang('Support is not included in the price of purchase and support extensions are not available for these items')</p>
                    @endif

                    <button type="submit" class="btn btn-md btn--base justify-content-center text-center mt-3 w-100"><i class="las la-cart-arrow-down fs-5 me-2"></i> @lang('Add To Cart')</button>

                  </form>
                </div><!-- product-widget end -->

                <div class="product-widget mt-4">
                  <div class="total-sale"><i class="las la-shopping-cart"></i> {{$product->total_sell}} @lang('Sales')</div>
                </div><!-- product-widget end -->
                <div class="product-widget mt-4">
                  <div class="author-widget">
                    <div class="thumb">
                      <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $product->user->image,imagePath()['profile']['user']['size'])}}" alt="image">
                    </div>
                    <div class="content">
                      <h5 class="author-name"><a href="{{route('username.search',strtolower($product->user->username))}}">{{$product->user->username}}</a></h5>
                    </div>

                    <ul class="author-info-list w-100 mt-3">
                      <li>
                        <span class="caption">@lang('Since')</span>
                        <span class="value">{{showDateTime($product->user->created_at,'d/m/Y')}}</span>
                      </li>
                      <li>
                        <span class="caption">@lang('Rating')</span>
                        <span class="value">
                            @php echo displayRating($product->user->avg_rating) @endphp
                        </span>
                      </li>
                      <li>
                        <span class="caption">@lang('Products')</span>
                        <span class="value">{{$product->user->products->count()}}</span>
                      </li>
                      <li>
                        <span class="caption">@lang('Sales')</span>
                        <span class="value">{{$product->user->products->sum('total_sell')}}</span>
                      </li>
                    </ul>
                    <ul class="author-badge-list w-100">
                        @foreach ($levels as $key => $item)
                            @if ($key+1 <= $product->user->level_id)
                                <li>
                                    <img src="{{ getImage(imagePath()['level']['path'].'/'. $item->image,imagePath()['level']['size'])}}" alt="@lang('image')">
                                </li>
                            @endif
                        @endforeach
                    </ul>
                  </div>
                </div><!-- product-widget end -->
                <div class="product-widget mt-4">
                  <div class="product-widget-info">
                    <h6 class="title">@lang('Last Update')</h6>
                    <p>{{showDateTime($product->updated_at,'d/m/y')}}</p>
                  </div>
                  <div class="product-widget-info">
                    <h6 class="title">@lang('First Release')</h6>
                    <p>{{showDateTime($product->created_at,'d/m/y')}}</p>
                  </div>
                  @foreach ($product->category_details as $key=> $item)
                    <div class="product-widget-info">
                        <h6 class="title">{{ucwords(str_replace('_',' ',$key))}}</h6>
                        <p>
                            @foreach ($item as $data)
                                {{__(str_replace('_',' ',$data))}} @if(!$loop->last),@endif
                            @endforeach
                        </p>
                    </div>
                  @endforeach

                  <div class="product-widget-info">
                    <h6 class="title mb-3">@lang('Tags')</h6>
                    <div class="product-widget-tags">
                        @foreach ($product->tag as $item)
                            <a href="{{route('tag.search',$item)}}">{{__($item)}}</a>
                        @endforeach
                    </div>
                  </div>
                </div><!-- product-widget end -->
              </div>
            </div>



    <!-- Modal -->
    <div class="modal fade" id="discount-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-4 text-center">
                    <h4>@lang('Better Safe than sorry'):)</h4>
                    <p>@lang('Get help when you need it most and extend support for') {{$general->extended}} @lang('more months')</p>
                    <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <hr>
                        <h6><del id="previous-value"></del></h6>
                        <h3 id="current-value"></h3>
                        <p>@lang('Save') <span id="discount-percentage"></span>% @lang('by extending now instead of after support has expired').</p>
                        <hr>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--base w-100" data-bs-dismiss="modal">@lang('Ok, got it')</button>
                </div>
            </div>
        </div>
    </div>




@push('script')
<script>

    'use strict';

    (function($) {
        $("#license-selectBox").on('change',function() {
            var resource = $(this).find('option:selected').data('resource');
            var type = $("#license-selectBox").val();

            if (type == 1) {
                var regular = parseFloat(resource.regular_price);
                $('#product-price').text(`{{$general->cur_sym}}${regular.toFixed(2)}`);

                if (resource.support) {
                    if (resource.support_discount) {
                        var amount = (regular * resource.support_charge) /100;
                        var lessCharge = (amount * resource.support_discount) /100;
                        console.log(lessCharge);
                        var final = parseFloat(amount - lessCharge);
                        $('#extendSupportShow').text(`{{$general->cur_sym}}${final.toFixed(2)}`);
                        $('#support-discount').text(`{{$general->cur_sym}}${lessCharge.toFixed(2)}`);

                        $("#extendSupport").on('change',function() {
                            if($('#extendSupport').is(":checked")){
                                var total = parseFloat(regular + final);
                                $('#product-price').text(`{{$general->cur_sym}}${total.toFixed(2)}`);
                            }else{
                                $('#product-price').text(`{{$general->cur_sym}}${regular.toFixed(2)}`);
                            }
                        });
                    }else{
                        var amount = parseFloat((regular * resource.support_charge) /100);
                        $('#extendSupportShow').text(`{{$general->cur_sym}}${amount.toFixed(2)}`);

                        $("#extendSupport").on('change',function() {
                            if($('#extendSupport').is(":checked")){
                                var total = parseFloat(regular + amount);
                                $('#product-price').text(`{{$general->cur_sym}}${total.toFixed(2)}`);
                            }else{
                                $('#product-price').text(`{{$general->cur_sym}}${regular.toFixed(2)}`);
                            }
                        });
                    }
                }
            }

            if (type == 2) {
                var extended = parseFloat(resource.extended_price);

                $('#product-price').text(`{{$general->cur_sym}}${extended.toFixed(2)}`);
                if (resource.support) {
                    if (resource.support_discount) {

                        var amount = (extended * resource.support_charge) /100;
                        var lessCharge = (amount * resource.support_discount) /100;
                        var final = parseFloat(amount - lessCharge);
                        $('#extendSupportShow').text(`{{$general->cur_sym}}${final.toFixed(2)}`);
                        $('#support-discount').text(`{{$general->cur_sym}}${lessCharge.toFixed(2)}`);

                        $("#extendSupport").on('change',function() {
                            if($('#extendSupport').is(":checked")){
                                var total = parseFloat(extended + final);
                                $('#product-price').text(`{{$general->cur_sym}}${total.toFixed(2)}`);
                            }else{
                                $('#product-price').text(`{{$general->cur_sym}}${extended.toFixed(2)}`);
                            }
                        });

                    }else{
                        var amount = (extended * resource.support_charge) /100;
                        $('#extendSupportShow').text(`{{$general->cur_sym}}${parseFloat(amount.toFixed(2))}`);

                        $("#extendSupport").on('change',function() {
                            if($('#extendSupport').is(":checked")){
                                var total = parseFloat(extended + amount);
                                $('#product-price').text(`{{$general->cur_sym}}${total.toFixed(2)}`);
                            }else{
                                $('#product-price').text(`{{$general->cur_sym}}${extended.toFixed(2)}`);
                            }
                        });
                    }
                }
            }

        }).change();

        $('.discount-calc').on('click', function () {
            var resource = $(this).data('resource');
            var type = $("#license-selectBox").val();

            if (type == 1) {
                var regular = parseFloat(resource.regular_price);

                if (resource.support) {
                    if (resource.support_discount) {
                        var amount = (regular * resource.support_charge) /100;
                        var lessCharge = (amount * resource.support_discount) /100;
                        var final = parseFloat(amount - lessCharge);

                        $("#previous-value").text(`{{$general->cur_sym}}${amount.toFixed(2)}`);
                        $("#current-value").text(`{{$general->cur_sym}}${final.toFixed(2)}`);
                        $("#discount-percentage").text(resource.support_discount);
                    }
                }
            }

            if (type == 2) {
                var extended = parseFloat(resource.extended_price);

                if (resource.support) {
                    if (resource.support_discount) {
                        var amount = (extended * resource.support_charge) /100;
                        var lessCharge = (amount * resource.support_discount) /100;
                        var final = parseFloat(amount - lessCharge);

                        $("#previous-value").text(`{{$general->cur_sym}}${amount.toFixed(2)}`);
                        $("#current-value").text(`{{$general->cur_sym}}${final.toFixed(2)}`);
                        $("#discount-percentage").text(resource.support_discount);
                    }
                }
            }
        });
    })(jQuery);
</script>
@endpush
