@extends(isStockholderAndLeft() ? 'template.master-stockholder-left-user' : 'template.master-user')

@section('title', 'تاریخچه معاملات')

@section('content')
    @include('template.messages')

    <div class="card ss02">

        <div class="card-content">
            <div class="card-body">
                <div class="stock-container">
                    <p class="stock-title">مثقال‌های محقق‌شده</p>
                    <p class="stock-number text-success">{{number_format($data['summary']['vested']['new'])}}</p>
                    <p class="subtext">ارزش امروز (تومان)</p>
                    <p class="extra">
                        <span>ارزش زمان قرارداد:</span>
                        <span>{{ number_format($data['summary']['vested']['old']) }} تومان</span>
                    </p>
                    <p class="extra">
                        <span>تعداد مثقال‌ها:</span>
                        <span>{{ number_format($data['summary']['vested']['count']) }}</span>
                    </p>
                </div>
                
                <h3 class="mt-10">معاملات من</h3>

                <div class="table-responsive">
                    <table class="table mb-0 table-lg">
                        <thead>
                        <tr>
                            <th scope="col">تاریخ و ساعت</th>
                            <th scope="col">شرح</th>
                            <th scope="col">تعداد مثقال</th>
                            <th scope="col">ارزش معامله شده</th>
                            <th scope="col">تومان (ارزش روز)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['trades'] as $trade)
                            <tr>
                                <td>{{$trade->created_at ? jdf_format($trade->created_at, "Y/m/d H:i") : null }}</td>
                                <td>{{$trade->description}}</td>
                                <td>{{number_format($trade->trade_value)}}</td>
                                <td>{{number_format($trade->tokens_quantity)}}</td>
                                <td>{{number_format($trade->tokens_quantity * $data['summary']['now_price'])}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            {{ $data['trades']->onEachSide(0)->links() }}
        </div>
    </div>
@endsection
