@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            @forelse($comments as $comment)
                <div class="card mb-3">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-12 border-bottom pb-3 mb-3">
                                <a href="#"> {{$comment->user->fullname}} </a> @ <small> {{showDateTime($comment->created_at)}} ({{diffForHumans($comment->created_at)}})</small>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#delComment" data-id="{{$comment->id}}" class="btn btn-sm btn--danger box--shadow1 text--small delete-comment float-right "><i class="las la-trash-alt"></i> @lang('Delete')</a>
                            </div>

                            <div class="col-md-12">
                                {{$comment->comment}}
                            </div>
                        </div>

                        @if($comment->replies()->count())
                            @foreach($comment->replies as $reply)

                                <div class="row p-3 m-3 admin-bg-reply border">
                                    <div class="col-md-12 border-bottom pb-3 mb-3">
                                        <a href="#"> {{$reply->user->fullname}} </a> @ <small>{{showDateTime($reply->created_at)}} ({{diffForHumans($reply->created_at)}})</small>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#delReply" data-id="{{$reply->id}}" class="btn btn-sm btn--danger box--shadow1 text--small delete-reply float-right"><i class="las la-trash-alt"></i> @lang('Delete')</a>
                                    </div>

                                    <div class="col-md-12">
                                        {{$reply->reply}}
                                    </div>

                                </div>

                            @endforeach
                        @endif

                    </div>
                </div>
            @empty
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 border-bottom pb-3 mb-3">
                                <small>{{__($empty_message)}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="modal fade" id="delComment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete Reply!')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>@lang('Are you sure to delete comment and related replies?')</strong>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('admin.comment.delete')}}">
                        @csrf
                        <input type="hidden" name="comment_id" class="comment-id">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No') </button>
                        <button type="submit" class="btn btn--danger"><i class="fa fa-trash"></i> @lang('Delete') </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="delReply" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete Reply!')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>@lang('Are you sure to delete reply?')</strong>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('admin.comment.reply.delete')}}">
                        @csrf
                        <input type="hidden" name="reply_id" class="reply-id">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No') </button>
                        <button type="submit" class="btn btn--danger"><i class="fa fa-trash"></i> @lang('Delete') </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection


@push('style')
    <style>
        .admin-bg-reply{
            color: #000;
            background-color: #F0F8FF;
            border-color: black;
        }
    </style>
@endpush


@push('script')
    <script>
        "use strict";
        $(document).ready(function () {

            $('.delete-comment').on('click', function (e) {
                $('.comment-id').val($(this).data('id'));
            });

            $('.delete-reply').on('click', function (e) {
                $('.reply-id').val($(this).data('id'));
            });

        });
    </script>
@endpush
