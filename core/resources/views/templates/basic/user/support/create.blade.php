@extends($activeTemplate.'layouts.frontend')
@section('content')

    @include($activeTemplate.'partials.dashboardHeader')

    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card custom--card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-10 d-flex flex-wrap align-items-center">
                                <h4 class="ms-2">@lang('New Ticket')</h4>
                            </div>
                            <div class="col-sm-2 text-end">
                                <a href="{{route('ticket')}}" class="btn btn--base btn-sm">@lang('My Support Tickets')</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>@lang('Name')</label>
                                    <input type="text" class="form-control" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}" readonly>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>@lang('E-mail Address')</label>
                                    <input type="email" class="form-control" name="email" value="{{@$user->email}}" readonly>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>@lang('Subject')</label>
                                    <input name="subject" value="{{old('subject')}}" placeholder="@lang('Enter ticket subject')..." class="form-control" required>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>@lang('Message')</label>
                                    <textarea name="message" placeholder="@lang('Your reply')..." class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-10 col-9">
                                        <label for="supportTicketFile" class="form-label">@lang('Select one file or multiple files')</label>
                                        <input class="form-control custom--file-upload" type="file" name="attachments[]" multiple>
                                        <div id="fileUploadsContainer"></div>
                                        <div class="form-text text--muted">@lang('Allowed File Extensions: .jpg, .jpeg, .png, .pdf')</div>
                                    </div>
                                    <div class="col-md-2 col-3 text-end mt-2">
                                        <a href="javascript:void(0)" onclick="extraTicketAttachment()" class="btn btn-sm w-100 py-2 btn--base reply-add">
                                            <i class="las la-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn--base"><i class="lab la-telegram-plane"></i> @lang('Submit')</button>
                                <button class=" btn btn--danger" type="button" onclick="formReset()">&nbsp;@lang('Cancel')</button>
                            </div>
                        </form>
                    </div>
                </div><!-- card end -->
            </div>
            </div>
        </div>
    </section>
@endsection


@push('script')
    <script>
        "use strict";
        function extraTicketAttachment() {
            $("#fileUploadsContainer").append(`<input class="form-control custom--file-upload mt-3" type="file" name="attachments[]" multiple>`)
        }
        function formReset() {
            window.location.href = "{{url()->current()}}"
        }
    </script>
@endpush
