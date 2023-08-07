@extends('template.master-admin')

@section('title', 'ویرایش symbol changes')

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 mx-auto">
            @include('template.messages')
            <div class="card my-4">
                <div class="card-body">
                    <form method="post" action="{{ url('admin/stock/symbolChanges/edit') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$data->id}}" />
                        <div class="form-group">
                            <label>تاریخ</label>
                            <input type="text" class="form-control" name="date" id="date" value="{{ $data->updated_at }}">
                            <input type="hidden" class="form-control" name="date_alt" id="date_alt">
                        </div>
                        <div class="form-group">
                            <label>شرح</label>
                            <input type="text" name="description" class="form-control" value="{{$data->description}}">
                        </div>
                        <div class="form-group">
                            <label>ارزش گذاری شرکت</label>
                            <input type="text" name="symbol_total_value" class="form-control" value="{{$data->symbol_total_value}}">
                        </div>
                        <div class="form-group">
                            <label>تعداد برگ سهام</label>
                            <input type="text" name="stock_block_quantity" class="form-control" value="{{$data->stock_block_quantity}}">
                        </div>
                        <button type="submit" class="btn btn-primary">ویرایش</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
@endpush

@push('js')
    <script src="{{ asset('js/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function () {
            
            $("#date").pDatepicker({
                altField: '#date_alt',
                altFormat: 'X'
            });
            
        });
    </script>
@endpush
