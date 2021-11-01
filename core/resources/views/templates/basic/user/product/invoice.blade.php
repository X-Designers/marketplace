<!DOCTYPE html>
<html lang="en" >
    <head>
    <meta charset="UTF-8">
    <title>@lang('Invoice')</title>
    <link rel="shortcut icon" href="{{ getImage(imagePath()['logoIcon']['path'] .'/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap3.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/invoice.css')}}">

    </head>
    <body>
        <div id="block1">
            <div class="print-container clearfix">
                <div class="header">
                    <div class="sub-header">
                        <div class="content">
                            <table style="width:100%">
                                <tr style="width:100%" class="heading">
                                <td colspan="3">
                                    <img class="invoice-logo" src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')" />
                                </td>
                                <td class="text-right">
                                    <div class="invoice-from" style="max-width:400px">
                                    <h3 class="mega">@lang('INVOICE')</h3>
                                <h6 class="grey">{{$productCheck->author->username}}</h6>
                                <p>{{$productCheck->author->address->country}}
                                        <br />
                                    <strong> {{$productCheck->author->email}}</strong>
                                    <br /></p>
                                    </div>

                                </td>
                                </tr>
                                <tr class="sub-heading">
                                    <td colspan="3">
                                        <div class="billto">
                                        <strong><big>{{$productCheck->user->getFullnameAttribute()}}</strong></big> <br />
                                        {{$productCheck->user->email}} <br />

                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="invoice-details">
                                            <span class="purchased-badge">@lang('Purchased')</span> <br/>
                                            <strong>@lang('Purchase Code') : </strong> {{$productCheck->code}} <br />
                                            <strong>@lang('Invoice Date'): </strong> {{\Carbon\Carbon::parse($productCheck->created_at)->format('Y-m-d')}} <br />
                                            <strong>@lang('Invoice Amount') : </strong> {{getAmount($productCheck->total_price)}}{{$general->cur_text}} <br />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="body">
                    <div class="summary-info">
                        <table class="table summary-table">
                            <thead>
                                <tr>
                                    <th>@lang('Product Name')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Licence Type')</th>
                                    <th>@lang('Support Time')</th>
                                    <th>@lang('Product Price')</th>
                                    <th>@lang('Support Fee')</th>
                                    <th>@lang('Amount')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="simple">
                                    <td>{{__($productCheck->product->name)}}</td>
                                    <td>{{__($productCheck->product->category->name)}}</td>
                                    @if ($productCheck->license == 1)
                                        <td>@lang('Regular')</td>
                                    @elseif ($productCheck->license == 2)
                                        <td>@lang('Extended')</td>
                                    @endif

                                    @if ($productCheck->support_time)
                                        <td>{{$productCheck->support_time}}</td>
                                    @else
                                        <td>@lang('No support')</td>
                                    @endif
                                    <td>{{$general->cur_sym}}{{getAmount($productCheck->product_price)}}</td>
                                    <td>{{$general->cur_sym}}{{getAmount($productCheck->support_fee)}}</td>
                                    <td>{{$general->cur_sym}}{{getAmount($productCheck->total_price)}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="other-rates clearfix">
                                    <dl class="dl-horizontal total clearfix">
                                        <dt class="blue">@lang('Total')</dt>
                                        <dd>{{$general->cur_sym}}{{getAmount($productCheck->total_price)}}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p style="font-size:12px" class="text-center">@lang('Copyright') © {{\Carbon\Carbon::now()->format('Y')}} | @lang('All Right Reserved by') {{$productCheck->author->username}}</p>
            </div>
        </div>
        <div class="print-container clearfix">
            <div class="row text-center">
                <div class="col-md-12">
                    <a href="javascript:void(0)" class="btn btn-primary btn-download">@lang('Download')</a>
                    <a href="javascript:window.history.back();" class="btn btn-default">@lang('Go Back')</a>
                </div>
            </div>
        </div>
        <script src="{{asset($activeTemplateTrue.'js/jquery-3.5.1.min.js')}}"></script>
        <script src="{{asset($activeTemplateTrue.'js/html2pdf.bundle.min.js')}}"></script>
        <script>
            "use strict";

            const options = {
                margin: 0.3,
                filename: '{{$filename}}',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'portrait'
                }
            }

            var objstr = document.getElementById('block1').innerHTML;

            var strr = objstr;

            $('.btn-download').click(function(e){
                e.preventDefault();
                var element = document.getElementById('demo');
                html2pdf().from(strr).set(options).save();
            });
        </script>
    </body>
</html>
