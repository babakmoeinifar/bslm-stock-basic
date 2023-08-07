@extends('template.master-admin')

@section('title', 'Symbol changes')

@section('content')
    @include('template.messages')

    <div class="card">
        <div class="card-header">

            <div class="row">
                <div class="col-9 col-md-6 col-sm-12">
                    <h3>تغییرات نماد ({{$data['symbol']['slug']}})</h3>
                    @if($data['symbol']['slug'])
                        <a href="{{url('admin/stock/symbolChanges/' . $data['symbol']['slug'] . '/new')}}">جدید</a>
                    @endif
                </div>
                <div class="col-3 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>انتخاب نماد</label>
                        <select class="form-control form-select food-list" name="select-symbol">
                            <option value="">----</option>
                            @foreach($data['symbols'] as $symbol)
                                <option {{$symbol['symbol_identifier']===$data['symbol']['slug'] ? 'selected="selected"' : ''}} value="{{$symbol['symbol_identifier']}}">{{$symbol['symbol_identifier']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-content">
            <div class="table-responsive">
                <table class="table mb-0 table-lg">
                    <thead>
                    <tr>
                        <th scope="col">تاریخ</th>
                        <th scope="col">ارزش هر توکن</th>
                        <th scope="col">تعداد توکن</th>
                        <th scope="col">ارزش گذاری شرکت</th>
                        <th scope="col">شرح</th>
                        <th scope="col">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['changes'] as $change)
                        <tr>
                            <td>{{$change->created_at ? jdf($change->created_at) : null }}</td>
                            <td>{{number_format($change->token_price)}}</td>
                            <td>{{number_format($change->stock_block_quantity)}}</td>
                            <td>{{number_format($change->symbol_total_value)}}</td>
                            <td>{{$change->description}}</td>
                            <td>
                                <a href="{{url('admin/stock/symbolChanges/' . $change->id . '/edit')}}">ویرایش</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            {{ $data['changes']->onEachSide(0)->links() }}
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

            $('.food-list').selectpicker({
                liveSearch: true
            });
        });
    </script>
@endpush