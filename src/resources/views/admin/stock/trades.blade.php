@extends('template.master-admin')

@section('title', 'خرید و فروش')

@section('content')
    @include('template.messages')

    <div class="card ss02">
        <div class="card-header">
            <h3>انتقال سهام</h3>
        </div>

        <div class="card-body pt-3">
            <form name="" method="post" action="{{ url('admin/stock/trades') }}">
                @csrf

                <div class="row">
                    <div class="col-2">
                        <div class="form-group">
                            <label>از</label>
                            <select class="form-control form-select food-list" name="shareholder">
                                <option value="">shareholder</option>
                                @foreach($data['shareholders'] as $sh)
                                    <option value="{{$sh->id}}">{{$sh->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>به</label>
                            <select class="form-control form-select food-list" name="employee">
                                <option value="">employee</option>
                                @foreach($data['users'] as $user)
                                    <option value="{{$user['id']}}">{{$user['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group text-start">
                            <label>تعداد مثقال</label>
                            <input type="number" name="count" class="form-control" value="{{ old('count') }}">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group text-start">
                            <label>قیمت هر مثقال <small>(تومان)</small></label>
                            <input type="text" name="price" class="form-control" value="{{ old('price') }}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group text-start">
                            <label>کد رهگیری تراکنش</label>
                            <input type="text" name="bank_receipt" class="form-control" value="{{ old('bank_receipt') }}">
                        </div>
                    </div>
                </div>
                
                <p class="text-center mb-0 mt-3">
                    <button type="submit" class="btn btn-primary">انتقال</button>
                </p>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">

            <div class="row">
                <div class="col-9 col-md-6 col-sm-12">
                    <h3>خرید و فروش</h3>
                    <!-- <a href="{{url('admin/stock/esops/' . $data['userid'] . '/new')}}">جدید</a> -->
                </div>
                <div class="col-3 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>انتخاب کاربر</label>
                        <select class="form-control form-select food-list" name="select-admin-trades-user">
                            <option value="">همه</option>
                            @foreach($data['users'] as $user)
                                <option {{$user['id'] == $data['userid'] ? 'selected="selected"' : ''}} value="{{$user['id']}}">{{$user['name']}}</option>
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
                        <th scope="col">#</th>
                        <th scope="col">شرح</th>
                        <th scope="col">توکن</th>
                        <th scope="col">تعداد توکن</th>
                        <th scope="col">ارزش معامله شده</th>
                        <th scope="col">ارزش روز</th>
                        <th scope="col">تاریخ و ساعت</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['trades'] as $trade)
                        <tr>
                            <td>{{$trade->id}}</td>
                            <td>{{$trade->description}}</td>
                            <td>{{ $data['now_prices'][$trade->symbol_id]['symbol_identifier'] }}</td>
                            <td>{{number_format($trade->tokens_quantity)}}</td>
                            <td>{{number_format($trade->trade_value)}}</td>
                            <td>{{number_format($trade->tokens_quantity * $data['now_prices'][$trade->symbol_id]['token_price'])}}</td>
                            <td>{{$trade->created_at ? jdf_format($trade->created_at, "Y/m/d H:i") : null }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            {{ $data['trades']->onEachSide(0)->links() }}
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