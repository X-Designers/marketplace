@extends('admin.layouts.app')

@section('panel')

    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">

            <div class="card">
                <div class="card-body">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('SL')</th>
                                    <th scope="col">@lang('User')</th>
                                    <th scope="col">@lang('Username')</th>
                                    <th scope="col">@lang('Featured at')</th>
                                    <th scope="col">@lang('Revoked at')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($authors as $item)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                        <td data-label="@lang('User')">
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.$item->user->image,imagePath()['profile']['user']['size'])}}" alt="@lang('image')">
                                                </div>
                                                <span class="name">{{$item->user->fullname}}</span>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Username')"><a href="{{ route('admin.users.detail', $item->user->id) }}">{{$item->user->username}}</a></td>
                                        <td data-label="@lang('Featured at')">{{showDateTime($item->created_at,'d M, Y')}} @if($loop->index == 0) <span class="badge badge--primary">@lang('Featured')</span> @endif</td>
                                        <td data-label="@lang('Revoked at')">{{$item->revoked_at ? showDateTime($item->revoked_at,'d M, Y'):'N/A'}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $authors->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Add METHOD MODAL --}}
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add New Level')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route('admin.users.make.featured')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Enter Username')</label>
                            <input type="text"class="form-control" placeholder="@lang('Valid username')" name="username" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('breadcrumb-plugins')
    <a href="javascript:void(0)" class="btn btn-sm btn--primary box--shadow1 text--small addBtn mb-4"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush

@push('script')
<script>
    'use strict';

    (function ($) {
        $('.addBtn').on('click', function () {
            var modal = $('#addModal');
            modal.modal('show');
        });

    })(jQuery);
</script>
@endpush
