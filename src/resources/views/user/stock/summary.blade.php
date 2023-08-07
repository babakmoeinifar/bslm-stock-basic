<div class="row row-cols-1 row-cols-md-3 mt-4">

        <div class="col mb-4">
            <div class="card">
                <div class="card-header text-center">My Vested Stock Summary</div>
                <div class="card-content" style="padding:15px">
                    <table style="width:100%" class="small">
                        <tr class="_text-center">
                            <td>ارزش روز توکن‌های من</td>
                            <td>{{number_format($data['summary']['vested']['new']) . ' تومان'}}</td>
                        </tr>
                        <tr class="_text-center">
                            <td>مبلغ معاملات من</td>
                            <td>{{number_format($data['summary']['vested']['old']) . ' تومان'}}</td>
                        </tr>
                        <tr class="_text-center">
                            <td>کل تعداد توکن‌های من</td>
                            <td>{{$data['summary']['vested']['count']}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card">
                <div class="card-header text-center">My ESOPs Summary</div>
                <div class="card-content" style="padding:15px">
                    <table style="width:100%" class="small">
                        <tr class="_text-center">
                            <td>ارزش روز non-vested esop من</td>
                            <td>{{number_format($data['summary']['non-vested']['new']) . ' تومان'}}</td>
                        </tr>
                        <tr class="_text-center">
                            <td>ارزش معامله شده non-vested esop من</td>
                            <td>{{number_format($data['summary']['non-vested']['old']) . ' تومان'}}</td>
                        </tr>
                    </table>
                    <p class="text-center"><a class="small" href="{{ url('stock/esops') }}">قرارداد های ESOP من</a></p>
                </div>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card">
                <div class="card-header text-center">اطلاعات نماد BSLM</div>
                <div class="card-content" style="padding:15px">
                    <table style="width:100%" class="small">
                        <tr class="text-center">
                            <td>ارزش روز هر توکن</td>
                            <td>{{number_format($data['summary']['symbol']['now_price']) . ' تومان'}}</td>
                        </tr>
                    </table>
                    <p class="text-center"><a class="small" href="{{url('stock/symbolChanges/BSLM')}}">تاریخچه تغییرات نماد</a></p>
                </div>
            </div>
        </div>

    </div>