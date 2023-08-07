@extends(isStockholderAndLeft() ? 'template.master-stockholder-left-user' : 'template.master-user')

@section('title', 'سهام')

@section('content')
    @include('template.messages')

    <div class="card ss02">
        <div class="card-content">
            <div class="card-body">

                <h3 class="mt-10">{{ getOption('brandName') }} لیتِرالی مال شماست!</h3>
                <p>طرح مالکیت سهام اعضا یا ESOP، یعنی هرچه {{ getOption('brandName') }} بیشتر رشد کند، شما هم سود بیشتری می‌برید.</p>
                <p class="mb-10"><a href="more-info">بیشتر بدانید</a></p>

                <div class="row row-cols-1 row-cols-md-2 _mt-12 mt-n5">
                    <div class="col mt-5">
                        <div class="stock-container">
                            <p class="stock-title">مثقال‌های محقق‌شده</p>
                            <p class="stock-number text-success">{{number_format($data['vested']['new'])}}</p>
                            <p class="subtext">ارزش روز (تومان)</p>
                            <p class="extra">
                                <span>ارزش زمان قرارداد:</span>
                                <span>{{ number_format($data['vested']['old']) }} تومان</span>
                            </p>
                            <p class="extra">
                                <span>تعداد مثقال‌ها:</span>
                                <span>{{ number_format($data['vested']['count']) }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="col mt-5">
                        <div class="stock-container">
                            <p class="stock-title">مثقال‌های آینده‌</p>
                            <p class="stock-number">{{ number_format($data['non-vested']['new']) }}</p>
                            <p class="subtext">ارزش روز (تومان)</p>
                            <p class="extra">
                                <span>ارزش زمان قرارداد:</span>
                                <span>{{ number_format($data['non-vested']['old']) }} تومان</span>
                            </p>
                            <p class="extra">
                                <span>تعداد مثقال‌ها:</span>
                                <span>{{ number_format($data['non-vested']['count']) }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <h3 class="mt-10">تاریخچه معاملات</h3>

                <div class="table-responsive">
                    <table class="table mb-0 table-lg">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">تاریخ قرارداد</th>
                            <th scope="col">عنوان</th>
                            <th scope="col">شرط تحقق</th>
                            <th scope="col">تعداد مثقال</th>
                            <th scope="col">ارزش زمان قرارداد</th>
                            <th scope="col">ارزش روز (تومان)</th>
                            <!--<th scope="col">تاریخ واگذاری سهام</th>-->
                            <th scope="col">تاریخ تحقق</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['esops'] as $esop)
                            <tr>
                                <td>{{ $esop->vesting_rule ? 'e-' . $esop->id : '' . $esop->id}}</td>
                                <td>{{$esop->contracted_at ? jdf($esop->contracted_at) : null}}</td>
                                <td>{{$esop->title}}</td>
                                <td>{{$esop->vesting_rule}} {{ $esop->will_vest_at ? '(' . jdf($esop->will_vest_at) . ')' : null }}</td>
                                <td>{{number_format($esop->tokens_quantity) }}</td>
                                <td>{{number_format($esop->esop_value)}}</td>
                                <td>{{$esop->tokens_quantity>0 ? number_format($esop->tokens_quantity*$data['now_price']) : null }}</td>
                                <!--<td>
                                    @if($esop->vested_at && !$esop->expired_at)
                                    <span class='badge bg-success'>{{ $esop->vested_at ? jdf($esop->vested_at) : null }}</span>

                                @endif
                                @if(!$esop->espired_at && \Carbon\Carbon::parse($esop->will_vest_at)->gt(\Carbon\Carbon::now()))
                                    <span class="badge bg-secondary">{{ $esop->will_vest_at ? jdf($esop->will_vest_at) : null }}</span>

                                @endif
                                </td>-->
                                <td>
                                    @if($esop->expired_at)
                                        <span class="badge bg-danger">
                                        محقق نشد:
                                        {{$esop->expiration_description}}
                                            {{jdf($esop->expired_at)}}
                                        </span>
                                    @endif
                                    @if($esop->vested_at && !$esop->expired_at)
                                        <span class="badge bg-success">
                                            {{ jdf($esop->vested_at) }}
                                        </span>
                                        <div class="text-sm text-success">{{ $esop->expiration_description }}</div>
                                    @endif
                                    @if(!$esop->vested_at && !$esop->expired_at)
                                        <span class="text-secondary">
                                            منتظر تحقق
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card ss02">
        <div class="card-content">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-1 mt-10">
                    <div class="col">
                        <div class="stock-container">
                            <p class="stock-title">ارزش روز مثقال</p>
                            <p class="stock-number">{{ number_format($data['symbol']['now_price']) }}</p>
                            <p class="subtext">تومان</p>
                            <div class="chart">
                                <canvas class="chart-symbol-changes" style="width: 100%; height: 200px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0 table-lg">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">تاریخ</th>
                            <th scope="col">ارزش هر مثقال</th>
                            <th scope="col">کل مثقال‌های شرکت</th>
                            <th scope="col">ارزش‌گذاری شرکت</th>
                            <th scope="col">شرح</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['changes'] as $change)
                            <tr>
                                <td>{{$change->id }}</td>
                                <td>{{$change->created_at ? jdf($change->created_at) : null }}</td>
                                <td>{{number_format($change->token_price)}}</td>
                                <td>{{number_format($change->stock_block_quantity)}}</td>
                                <td>{{number_format($change->symbol_total_value)}}</td>
                                <td>{{$change->description}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        var chart_config = {
            type: 'line',
            data: {
                labels: <?php echo json_encode($data['symbol']['chart']['labels']); ?>,
                datasets: [{
                    label: '',
                    "data": <?php echo json_encode($data['symbol']['chart']['values']); ?>,
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointHoverRadius: 3,
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: false,
                title: {
                    display: true,
                    text: ''
                },
                legend: {
                    display: false
                },
                scales: {
                    x: {
                        display: true,
                    },
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }
        };
        var ctx = $('.chart-symbol-changes')[0].getContext('2d');
        ctx.height = 300;
        window.myLine = new Chart(ctx, chart_config);
        Chart.defaults.global.defaultFontFamily = "sans";
        window.myLine.update();
    </script>
@endpush
