@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Reviewers')</th>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Mobile')</th>
                                <th scope="col">@lang('Joined At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($reviewers as $item)
                                <tr>
                                    <td data-label="@lang('Reviewers')">
                                        <div class="user">
                                            <div class="thumb"><img src="{{ getImage(imagePath()['profile']['reviewer']['path'].'/'. $item->image,imagePath()['profile']['reviewer']['size'])}}" alt="image"></div>
                                            <span class="name">{{$item->name}}</span>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Username')"><a href="{{ route('admin.reviewers.detail', $item->id) }}">{{ $item->username }}</a></td>
                                    <td data-label="@lang('Email')">{{ $item->email }}</td>
                                    <td data-label="@lang('Phone')">{{ $item->mobile }}</td>
                                    <td data-label="@lang('Joined At')">{{ showDateTime($item->created_at) }}</td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.reviewers.detail', $item->id) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="Details">
                                            <i class="las la-desktop text--shadow"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $reviewers->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>


    </div>
@endsection



@push('breadcrumb-plugins')
    <form action="{{ route('admin.reviewers.search', $scope ?? str_replace('admin.reviewers.', '', request()->route()->getName())) }}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username or email')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
