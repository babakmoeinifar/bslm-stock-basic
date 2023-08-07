@extends('template.master-admin')

@section('title', 'گزارش معاملات مثقال')

@section('content')
    @include('template.messages')

    <div class="card ss02">
        <div class="card-header">
            <h3>گزارش معاملات مثقال
                <a href="{{ url('admin/stock/trades-history/create') }}" class="btn btn-light-primary">
                    افزودن
                </a></h3>
        </div>

        <div class="card-body">
            <div class="table-responsive ss02">
                <table class="table mb-0 table-lg">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">بازه</th>
                        <th scope="col">نماد</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($histories as $history)
                    <tr>
                        <th scope="row">{{ $history->id }}</th>
                        <td>{{ $history->title }}</td>
                        <td>{{ $history->symbol_id == 1 ? 'BSLM' : '' }}</td>
                        <td class="d-flex justify-content-end">
                            <a href="{{ url('admin/stock/trades-history/'.$history->id) }}" class="btn btn-primary btn-sm">ویرایش</a>&nbsp;
                            <form action="{{ url('admin/stock/trades-history/'.$history->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- End -->
        </div>
    </div>
    <div class="mt-5 ss02">
        {!! $histories->onEachSide(0)->links() !!}
    </div>
@endsection

