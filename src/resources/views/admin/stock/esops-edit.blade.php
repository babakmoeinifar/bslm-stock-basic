@extends('template.master-admin')

@section('title', 'ویرایش قرارداد')

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 mx-auto">
            @include('template.messages')
            <div class="card my-4">
                <div class="card-body">
                    <h3>ویرایش قرارداد</h3>
                    <form method="post" action="{{ url('admin/stock/esops/edit/' . $data['data']->id ) }}">
                        @csrf
                        
                        <!--<div class="form-group">
                            <label>انتخاب کاربر</label>
                            <select class="form-control form-select food-list" name="select-user">
                                <option value="">همه</option>
                                @foreach($data['users'] as $user)
                                    <option  value="{{$user['id']}}">{{$user['name']}}</option>
                                @endforeach
                            </select>
                        </div>-->
                        <div class="form-group">
                            <label>نماد</label>
                            <select class="form-control form-select food-list" name="select_new_esop_symbol">
                                <option value="">---</option>
                                @foreach($data['symbols'] as $symbol)
                                    <option @if($data['data']->symbol_id == $symbol['id']) selected="selected" @endif value="{{$symbol->id}}" >{{$symbol->symbol_identifier}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group disable">
                            <label>قیمت فعلی</label>
                            <input type="text" name="price" class="form-control" value="{{ $data['now_price'] }}">
                        </div>
                        <div class="form-group">
                            <label>عنوان</label>
                            <input type="text" name="title" class="form-control" value="{{ $data['data']->title }}">
                        </div>
                        <div class="form-group">
                            <label>قیمت توکن</label>
                            <input type="text" name="token_price" class="form-control" value="{{ $data['data']->token_price }}">
                        </div>
                        <div class="form-group">
                            <label>تعداد توکن</label>
                            <input type="number" name="quantity" class="form-control" value="{{ $data['data']->tokens_quantity }}">
                        </div>
                        <div class="form-group">
                            <label>تاریخ عقد قرارداد</label>
                            <input type="text" class="form-control" name="" id="contracted_at" value="{{ $data['data']->contracted_at }}">
                            <input type="hidden" class="form-control" name="contracted_at_alt" id="contracted_at_alt">
                        </div>
                        <div class="form-group">
                            <label>vesting rule</label>
                            <input type="text" name="vesting_rule" class="form-control" value="{{ $data['data']->vesting_rule }}">
                        </div>
                        <div class="form-group">
                            <label>تاریخ vest</label>
                            <input type="text" class="form-control" name="" id="vest_at" value="{{ $data['data']->will_vest_at }}">
                            <input type="hidden" class="form-control" name="vest_at_alt" id="vest_at_alt">
                        </div>

                        <button type="submit" class="btn btn-primary">ویرایش</button>
                        <a class="btn btn-secondary" href="{{ url('/admin/stock/esops/' . @$data['user']->id) }}">بازگشت</a>
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
            $("#vest_at").pDatepicker({
                altField: '#vest_at_alt',
                altFormat: 'X'
            });

            $("#contracted_at").pDatepicker({
                altField: '#contracted_at_alt',
                altFormat: 'X'
            });

            // $('.food-list').selectpicker({
            //     liveSearch: true
            // });
            
            $('[name="select-user"]').selectpicker({
                liveSearch: true
            });
        });
    </script>
@endpush
