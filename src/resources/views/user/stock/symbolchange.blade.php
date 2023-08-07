@extends(isStockholderAndLeft() ? 'template.master-stockholder-left-user' : 'template.master-user')

@section('title', 'تغییرات ارزش هر مثقال')

@section('content')
    @include('template.messages')

    <div class="card ss02">
        <div class="card-content">
            <div class="card-body">
                
                <div class="stock-container">
                    <p class="stock-title">تغییرات ارزش هر مثقال</p>
                    <p class="stock-number">{{ number_format($data['summary']['symbol']['now_price']) }}</p>
                    <p class="subtext">ارزش امروز (تومان)</p>
                    <div class="chart">
                        <canvas class="chart-symbol-changes" style="width: 100%; height: 200px;"></canvas>
                    </div>
                </div>
                <h3 class="mt-10">تغییرات ارزش هر مثقال</h3>

                <div class="table-responsive">
                    <table class="table mb-0 table-lg">
                        <thead> 
                        <tr>
                            <th scope="col">تاریخ</th>
                            <th scope="col">ارزش هر مثقال</th>
                            <th scope="col">تعداد برگ سهام</th>
                            <th scope="col">ارزش گذاری شرکت</th>
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
        <div class="card-footer d-flex justify-content-between">
            {{ $data['changes']->onEachSide(0)->links() }}
        </div>
    </div>
@endsection

@push('js')
<script>
    var chart_config = {
		type: 'line',
		data: {
			labels: <?php echo json_encode($data['summary']['symbol']['chart']['labels']); ?>,
			datasets: [{
			    label: '',
				"data": <?php echo json_encode($data['summary']['symbol']['chart']['values']); ?>,
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
