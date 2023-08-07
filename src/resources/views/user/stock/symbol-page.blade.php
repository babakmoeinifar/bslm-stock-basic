@extends(isStockholderAndLeft() ? 'template.master-stockholder-left-user' : 'template.master-user')

@section('title', 'نماد')

@section('content')
    @include('template.messages')

    <div class="d-flex justify-content-between">
        <div class="ss02">
            <div class="d-flex">
                <h3>نماد {{ $data['symbol']['slug'] }}</h3>
                <p>&nbsp;&nbsp;&nbsp;&nbsp; {{ $data['symbol']['company_name'] }}</p>
            </div>

        </div>
        <form action="{{ url('stock/symbol/') }}" class="col-md-2 col-sm-3 col-6">

            <select name="slug" id="slug" class="form-select"
                    onchange="this.form.submit()">

                @foreach($data['symbols'] as $symbol)
                    <option value="{{ $symbol->symbol_identifier }}"
                            @if($symbol->id == $data['symbol']['id']) selected @endif>
                        {{ $symbol->symbol_identifier }} - {{ $symbol->company_name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>


    @php($histories = $data['histories'])

    @if(count($histories) > 0)
        <div class="card ss02">
            <div class="card-header pb-0">
                <h4>گزارش معاملات مثقال</h4>
                <small>ارز: تومان</small>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-1 mb-2 ">
                        <div class="col">
                            <div class="stock-container">
                                <p class="stock-title">قیمت معاملاتی مثقال</p>
                                <div class="chart">
                                    <canvas class="chart-symbol-history" style="width: 100%; height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary my-3" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseMesqal" aria-expanded="false" aria-controls="collapseMesqal">
                        دیدن جزئیات
                    </button>
                    <div class="collapse" id="collapseMesqal" style="overflow: auto">
                        <table class="table table-bordered" id="historyTable">
                            <tr>
                                <td id="historyTitle">بازه</td>
                                @foreach($histories as $history)
                                    <th id="historyValue">{{ $history->title }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <td id="historyTitle">
                                <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                      data-bs-toggle="tooltip"
                                      title="{{ \App\Enums\StockHistoryTableToolTipsEnum::min_stock_transfer_price }}">
                                        حداقل قیمت مثقال
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->min_stock_transfer_price) }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td id="historyTitle">
                                <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                      data-bs-toggle="tooltip"
                                      title="{{ \App\Enums\StockHistoryTableToolTipsEnum::max_stock_transfer_price }}">
                                        حداکثر قیمت مثقال
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->max_stock_transfer_price) }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td id="historyTitle">
                                <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                      data-bs-toggle="tooltip"
                                      title="{{ \App\Enums\StockHistoryTableToolTipsEnum::min_stock_price }}">
                                        کران پایین قیمت مثقال
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->min_stock_price) }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td id="historyTitle">
                                <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                      data-bs-toggle="tooltip"
                                      title="{{ \App\Enums\StockHistoryTableToolTipsEnum::max_stock_price }}">
                                        کران بالای قیمت مثقال
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->max_stock_price) }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td id="historyTitle">
                                <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                      data-bs-toggle="tooltip"
                                      title="{{ \App\Enums\StockHistoryTableToolTipsEnum::trades_total_value }}">
                                        ارزش کل معاملات
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->trades_total_value) }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td id="historyTitle">
                                 <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                       data-bs-toggle="tooltip"
                                       title="{{ \App\Enums\StockHistoryTableToolTipsEnum::stock_weighted_average_price }}">
                                        میانگین وزنی قیمت مثقال
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->stock_weighted_average_price) }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td id="historyTitle">
                                 <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                       data-bs-toggle="tooltip"
                                       title="{{ \App\Enums\StockHistoryTableToolTipsEnum::supply_volume }}">
                                        حجم عرضه
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->supply_volume) }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td id="historyTitle">
                                 <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                       data-bs-toggle="tooltip"
                                       title="{{ \App\Enums\StockHistoryTableToolTipsEnum::demand_volume }}">
                                        حجم تقاضا
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->demand_volume) }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td id="historyTitle">
                                 <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                       data-bs-toggle="tooltip"
                                       title="{{ \App\Enums\StockHistoryTableToolTipsEnum::traded_volume }}">
                                        حجم معاملات
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->traded_volume) }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td id="historyTitle">
                                 <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                       data-bs-toggle="tooltip"
                                       title="{{ \App\Enums\StockHistoryTableToolTipsEnum::highest_volume }}">
                                        حجم بزرگ‌ترین معامله
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->highest_volume) }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td id="historyTitle">
                                  <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                        data-bs-toggle="tooltip"
                                        title="{{ \App\Enums\StockHistoryTableToolTipsEnum::number_of_traders }}">
                                        تعداد معامله‌کنندگان
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->number_of_traders) }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td id="historyTitle">
                                  <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                        data-bs-toggle="tooltip"
                                        title="{{ \App\Enums\StockHistoryTableToolTipsEnum::number_of_trades }}">
                                        تعداد معاملات
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->number_of_trades) }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td id="historyTitle">
                                  <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                        data-bs-toggle="tooltip"
                                        title="{{ \App\Enums\StockHistoryTableToolTipsEnum::number_of_suppliers }}">
                                        تعداد عرضه‌کنندگان
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->number_of_suppliers) }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td id="historyTitle">
                                  <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                        data-bs-toggle="tooltip"
                                        title="{{ \App\Enums\StockHistoryTableToolTipsEnum::number_of_demanders }}">
                                        تعداد تقاضاکنندگان
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ number_format($history->number_of_demanders) }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td id="historyTitle">
                                  <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                        data-bs-toggle="tooltip"
                                        title="{{ \App\Enums\StockHistoryTableToolTipsEnum::bull_or_bear_market }}">
                                        بازار صعودی یا نزولی
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">{{ $history->bull_or_bear_market == 1 ? '↑' : '↓' }}</td>
                                @endforeach
                            </tr>

                            <tr style="height: 50px">
                                <td id="historyTitle">
                                  <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                        data-bs-toggle="tooltip"
                                        title="{{ \App\Enums\StockHistoryTableToolTipsEnum::technical_analysis }}">
                                        تحلیل فنی
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td>
                                        <button class="btn btn-link" data-bs-toggle="modal"
                                    <td id="historyValue">
                                        <button class="btn btn-link btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#techModal{{$history->id}}">
                                            {{ \Illuminate\Support\Str::limit($history->technical_analysis,30) }}
                                        </button>
                                    </td>
                                    <div class="modal fade" id="techModal{{$history->id}}" tabindex="-1"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title"
                                                        id="exampleModalLabel">تحلیل فنی
                                                        نماد {{ $history->symbol_id ==1 ? 'BSLM' : '' }}
                                                        در {{ $history->title }}</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ $history->technical_analysis }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tr>

                            <tr>
                                <td id="historyTitle">
                                  <span class="d-inline-block" data-bs-placement="right" tabindex="0"
                                        data-bs-toggle="tooltip"
                                        title="{{ \App\Enums\StockHistoryTableToolTipsEnum::fundamental_analysis }}">
                                        تحلیل بنیادی
                                    </span>
                                </td>
                                @foreach($histories as $history)
                                    <td id="historyValue">
                                        <button class="btn btn-link btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#fundModal{{$history->id}}">
                                            {{ \Illuminate\Support\Str::limit($history->fundamental_analysis,30) }}
                                        </button>
                                    </td>
                                    <div class="modal fade" id="fundModal{{$history->id}}" tabindex="-1"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title"
                                                        id="exampleModalLabel">تحلیل بنیادی
                                                        نماد {{ $history->symbol_id ==1 ? 'BSLM' : '' }}
                                                        در {{ $history->title }}</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ $history->fundamental_analysis }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    @endif

    <div class="card ss02">
        <div class="card-content">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-1 mt-10">
                    <div class="col">
                        <div class="stock-container">
                            <p class="stock-title">ارزش بنیادی مثقال</p>
                            <p class="stock-number">{{ number_format($data['symbol']['now_price']) }}</p>
                            <p class="subtext">تومان</p>
                            <div class="chart">
                                <canvas class="chart-symbol-changes" style="width: 100%; height: 200px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary my-3" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    دیدن جزئیات
                </button>
                <div class="collapse" id="collapseExample">
                    <div class="table-responsive">
                        <table class="table mb-0 table-lg">
                            <thead>
                            <tr>
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
    </div>

@endsection
@push('css')
    <style>
        th:first-child, td:first-child {
            position: sticky;
            right: 0px;
            background-color: #efefef;
            font-weight: bold;
            font-size: 12px;
        }

        #historyTitle {
            width: 155px;
            max-width: 155px;
            min-width: 155px;
        }

        #historyValue {
            min-width: 150px;
            max-width: 150px;
            font-size: 12px;
        }
    </style>
@endpush
@push('js')
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

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
    <script>
        var chart_history_config = {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels ?? ''); ?>,
                datasets: [
                    {
                        label: 'میانگین وزنی قیمت مثقال',
                        "data": <?php echo json_encode($data['stock_weighted_average_price'] ?? ''); ?>,
                        lineTension: 0.3,
                        backgroundColor: "#26a32c",
                        borderColor: "#26a32c",
                        lineColor: "#26a32c",
                        pointRadius: 3,
                        pointHoverRadius: 3,
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        yAxisID: "A"
                    },
                    {
                        label: 'ارزش کل معاملات (تومان)',
                        "data": <?php echo json_encode($data['trades_total_value'] ?? ''); ?>,
                        lineTension: 0.3,
                        backgroundColor: "#153f7a",
                        borderColor: "#153f7a",
                        lineColor: "#153f7a",
                        pointRadius: 3,
                        pointHoverRadius: 3,
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        yAxisID: "B"
                    }
                ]
            },
            options: {
                responsive: false,
                title: {
                    display: true,
                    text: ''
                },
                legend: {
                    display: true,
                },
                scales: {
                    x: {
                        display: true,
                    },
                    yAxes: [{
                        id: 'A',
                        type: 'linear',
                        position: 'left',
                        grid: {
                            drawOnChartArea: false,
                        },
                    }, {
                        id: 'B',
                        type: 'linear',
                        position: 'right',
                        max: 100,
                        min: 0,
                        grid: {
                            drawOnChartArea: false,
                        },
                    }]
                }
            }
        };
        var ctx_history = $('.chart-symbol-history')[0].getContext('2d');
        ctx_history.height = 300;
        window.myLine = new Chart(ctx_history, chart_history_config);
        Chart.defaults.global.defaultFontFamily = "sans";
        window.myLine.update();
    </script>
@endpush