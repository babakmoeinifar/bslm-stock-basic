@extends('template.master-admin')

@section('title', 'ویرایش گزارش مثقال')

@section('content')
    <div class="row">
        <div class="col-12 col-md-6">
            @include('template.messages')
            <div class="card my-4">
                <div class="card-body">
                    <form method="post" action='{{ url("admin/stock/trades-history/{$history->id}") }}'>
                        @include('stock::admin.stock.tradesHistory._form', ['buttonText' => 'ویرایش'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
