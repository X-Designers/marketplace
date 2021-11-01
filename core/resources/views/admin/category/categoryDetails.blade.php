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
                                    <th scope="col">@lang('Subject Name')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($categoryDetails as $item)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                        <td data-label="@lang('Subject Name')">{{ $item->name }}</td>
                                        <td data-label="@lang('Action')">
                                            <a href="{{route('admin.category.details.edit',[$item->category->id,$item->id])}}" class="icon-btn updateBtn"><i class="la la-pencil-alt"></i></a>
                                        </td>
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
                    {{ $categoryDetails->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>

    @push('breadcrumb-plugins')
        <a href="{{route('admin.category')}}" class="btn btn-sm btn--primary box--shadow1 text--small addBtn mb-4"><i class="las la-angle-double-left"></i>@lang('Go Back')</a>
        <a href="{{route('admin.category.details.new',$category->id)}}" class="btn btn-sm btn--primary box--shadow1 text--small mb-4"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
    @endpush
@endsection

