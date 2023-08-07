@extends(isStockholderAndLeft() ? 'template.master-stockholder-left-user' : 'template.master-user')

@section('title', 'راهنمای معامله مثقال')

@section('content')
    @include('template.messages')
    <div class="card ss02">
        <div class="card-content">

            <div class="card-body">
                {!! $data !!}
            </div>
        </div>
    </div>
@endsection

