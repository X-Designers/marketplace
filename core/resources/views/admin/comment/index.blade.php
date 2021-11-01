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
                                    <th scope="col">@lang('Image')</th>
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Total Comment')</th>
                                    <th scope="col">@lang('Details')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($products as $item)
                                    <tr>
                                        <td data-label="@lang('Image')">
                                            <div class="user justify-content-center">
                                                <div class="thumb"><img src="{{ getImage(imagePath()['p_image']['path'].'/thumb_'. $item->image,imagePath()['p_image']['size'])}}" alt="@lang('image')"></div>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Name')">{{ $item->name }}</td>
                                        <td data-label="@lang('Total Comment')">{{$item->comments->count()}}</td>
                                        <td data-label="@lang('Details')">
                                            <a href="{{route('admin.comment.view',$item->id)}}" data-toggle="tooltip" title="@lang('Comments')" data-original-title="@lang('Comments')" class="icon-btn"><i class="las la-comments"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $products->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>

@endsection
