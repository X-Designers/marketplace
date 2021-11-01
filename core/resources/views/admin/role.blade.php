@extends('admin.layouts.app')
@section('panel')
@php
    $accesses = json_decode(file_get_contents(resource_path('views/admin/access.json')));
@endphp
    <div class="row mb-none-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table--light style--two">
                        <tbody>
                    @foreach($accesses as $key => $access)
                            <tr>
                                <td>
                                    <input type="checkbox" name="" class="mr-2 acLevel" id="{{ $key }}">
                                    <label for="{{ $key }}">{{ $key }}</label>
                                @if(is_object($access))
                                    <table class="table table--light style--two d-none">
                                        <tbody>
                                            @foreach($access as $k => $ac)
                                                @include('admin.arr',['k'=>$k,'ac'=>$ac])
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                </td>
                            </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script type="text/javascript">
    $('.acLevel').on('input',function(){
        var prTd = $(this).parent('td');
        if ($(this).prop("checked") == true) {
           prTd.children('table').removeClass('d-none');
        }else{
           prTd.children('table').addClass('d-none');
        }
    });
</script>
@endpush