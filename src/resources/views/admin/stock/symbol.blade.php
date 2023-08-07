@extends('template.master-admin')

@section('title', 'Symbol changes')

@section('content')
    @include('template.messages')

    <div class="card">
        <div class="card-header">
            <div class="col-9 col-md-6 col-sm-12">
                <h3>نمادها</h3>
                <a href="{{url('admin/stock/symbol/new')}}">جدید</a>
            </div>
        </div>

        <div class="card-content">
            <div class="table-responsive">
                <table class="table mb-0 table-lg">
                    <thead>
                    <tr>
                        <th scope="col">نماد</th>
                        <th scope="col">نام شرکت</th>
                        <th scope="col">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['symbols'] as $symbol)
                        <tr>
                            <td>{{$symbol->symbol_identifier}}</td>
                            <td>{{$symbol->company_name}}</td>
                            <td>
                                <a href="{{url('admin/stock/symbol/' . $symbol->id . '/edit')}}">ویرایش</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            {{ $data['symbols']->onEachSide(0)->links() }}
        </div>
    </div>
@endsection
