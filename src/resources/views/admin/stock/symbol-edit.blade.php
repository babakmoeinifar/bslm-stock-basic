@extends('template.master-admin')

@section('title', 'ویرایش نماد')

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 mx-auto">
            @include('template.messages')
            <div class="card my-4">
                <div class="card-body">
                    <h3>ویرایش نماد</h3>
                    <form method="post" action="{{ url('admin/stock/symbol/edit') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$data->id}}" />
                        <div class="form-group">
                            <label>نام نماد</label>
                            <input type="text" name="identifier" class="form-control" value="{{$data->symbol_identifier}}">
                        </div>
                        <div class="form-group">
                            <label>نام شرکت</label>
                            <input type="text" name="company" class="form-control" value="{{$data->company_name}}">
                        </div>
                        <button type="submit" class="btn btn-primary">ویرایش</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
