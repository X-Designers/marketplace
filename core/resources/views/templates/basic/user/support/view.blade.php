@extends($activeTemplate.'layouts.frontend')

@section('content')
@include($activeTemplate.'partials.breadcrumb')

    <!-- support section start -->
    <section class="pt-100 pb-100">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
            <div class="card custom--card">
                <div class="card-header">
                <div class="row">
                    <div class="col-sm-10 d-flex flex-wrap align-items-center">

                        @if($my_ticket->status == 0)
                            <span class="badge badge--success">@lang('Open')</span>
                        @elseif($my_ticket->status == 1)
                            <span class="badge badge--success">@lang('Answered')</span>
                        @elseif($my_ticket->status == 2)
                            <span class="badge badge--success">@lang('Replied')</span>
                        @elseif($my_ticket->status == 3)
                            <span class="badge badge--success">@lang('Closed')</span>
                        @endif
                        <h4 class="ms-2">[@lang('Ticket') :#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}</h4>
                    </div>
                    <div class="col-sm-2 text-end">
                    <button class="btn btn--danger btn-sm" data-bs-toggle="modal" data-bs-target="#DelModal"><i class="las la-times"></i></button>
                    </div>
                </div>
                </div>
                <div class="card-body">
                    @if($my_ticket->status != 4)
                        <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <textarea name="message" placeholder="@lang('Your reply')..." class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="supportTicketFile" class="form-label">@lang('Select one file or multiple files')</label>
                                        <input class="form-control custom--file-upload" type="file" name="attachments[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
                                        <div id="fileUploadsContainer"></div>
                                        <div class="form-text text--muted">@lang('Allowed File Extensions: .jpg, .jpeg, .png, .pdf')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-end">
                                <button type="submit" class="btn btn--base w-100 py-2" name="replayTicket" value="1">@lang('Reply')</button>
                            </div>
                        </form>
                    @endif

                    @foreach($messages as $message)
                        @if($message->admin_id == 0)
                            <div class="single-reply">
                                <div class="left">
                                    <h4>{{ $message->ticket->name }}</h4>
                                </div>
                                <div class="right">
                                    <span class="fst-italic font-size--14px text--base mb-2">@lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                    <p>{{$message->message}}</p>

                                    @if($message->attachments()->count() > 0)
                                        <div class="attachment-list mt-2">
                                            @foreach($message->attachments as $k=> $image)
                                                <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i> @lang('Attachment') {{++$k}}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div><!-- single-reply end -->
                        @else
                            <div class="single-reply admin-reply">
                                <div class="left">
                                    <h4>@lang('Staff')</h4>
                                </div>

                                <div class="right">
                                    <span class="fst-italic font-size--14px text--base mb-2">@lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                    <p>{{$message->message}}</p>

                                    @if($message->attachments()->count() > 0)
                                        <div class="attachment-list mt-2">
                                            @foreach($message->attachments as $k=> $image)
                                                <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i> @lang('Attachment') {{++$k}}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div><!-- single-reply end -->
                        @endif
                    @endforeach
                </div>
            </div><!-- card end -->
            </div>
        </div>
        </div>
    </section>
    <!-- support section end -->

    <div class="modal fade" id="DelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('ticket.reply', $my_ticket->id) }}" method="POST">
                    @csrf
                        <div class="modal-header">
                            <h4>@lang('Confirmation')!</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <strong class="text-dark">@lang('Are you sure you want to close this ticket')?</strong>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-md px-4 btn--danger" data-bs-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn-md px-4 btn--base" name="replayTicket" value="2">@lang('Yes')</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
