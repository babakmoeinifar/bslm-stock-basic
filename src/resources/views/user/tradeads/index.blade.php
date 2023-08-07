@extends(isStockholderAndLeft() ? 'template.master-stockholder-left-user' : 'template.master-user')

@section('title', 'آگهی‌های خرید و فروش مثقال')

@section('content')
    @include('template.messages')

    @if($data['stock-trade-ads-top-text'])
        <div class="mb-3">
            {!! $data['stock-trade-ads-top-text'] !!}
        </div>
    @endif

    <div class="card ss02">
        <div class="card-content">
            <div class="card-body">
                <h3 class="d-flex justify-content-between">
                    آگهی‌های فروش
                    <small class="text-muted">
                        <a href="" class="btn btn-light btn-open-trade" data-min="{{$data['min']}}"
                           data-max="{{$data['max']}}" data-type="-1">می‌خوام بفروشم</a>
                    </small>

                </h3>

                <div class="table-responsive">
                    <table class="table mb-0 table-md">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">آگهی دهنده</th>
                            <th scope="col">قیمت مثقال (تومان)</th>
                            <th scope="col">تعداد مثقال</th>
                            <th scope="col">ارزش کل (تومان)</th>
                            <th scope="col">تاریخ</th>
                            <th scope="col" class="text-center"><span class="bi bi-list"></span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['trades-sell'] as $trade)
                            <tr>
                                <td>{{ $trade->id}}</td>
                                <td>
                                    <a href="{{ url('contacts/' . $trade->employee_id) }}">{{ $trade->creator_name}}</a>
                                </td>
                                <td>{{ number_format($trade->token_price) }}</td>
                                <td>{{ number_format($trade->token_quantity) }}</td>
                                <td>{{ number_format($trade->token_price * $trade->token_quantity) }}</td>
                                <td>{{ jdf_format($trade->created_at, 'Y/m/d') }}</td>
                                <td>
                                    @if($trade->user_id == auth()->id() || is_admin())
                                        @if(is_admin() && $trade->user_id != auth()->id())
                                            <form action="{{ url('trade/delete/') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="trade" value="{{ $trade->id }}">
                                                <button type="submit" class="btn btn-danger">
                                                    remove as admin
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ url('trade/delete/') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="trade" value="{{ $trade->id }}">
                                                <button type="submit" class="btn btn-danger">
                                                    حذف
                                                </button>
                                            </form>
                                        @endif
                                        {{--                                                                    @else--}}
                                        {{--                                                                        <a href="" data-certman_username="{{ $trade->certman_username }}" data-mobile="{{ $trade->mobile }}" data-id="{{ $trade->id }}" class="btn btn-light goForTrade">ثبت سفارش</a>--}}
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

                <h3 class="d-flex justify-content-between">
                    آگهی‌های خرید
                    <small class="text-muted">
                        <a href="" class="btn btn-light btn-open-trade" data-min="{{$data['min']}}"
                           data-max="{{$data['max']}}" data-type="1">می‌خوام بخرم</a>
                    </small>

                </h3>

                <div class="table-responsive">
                    <table class="table mb-0 table-md">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">آگهی دهنده</th>
                            <th scope="col">قیمت مثقال (تومان)</th>
                            <th scope="col">تعداد مثقال</th>
                            <th scope="col">ارزش کل (تومان)</th>
                            <th scope="col">تاریخ</th>
                            <th scope="col" class="text-center"><span class="bi bi-list"></span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['trades-buy'] as $trade)
                            <tr>
                                <td>{{ $trade->id}}</td>
                                <td><a href="{{ url('contacts/' . $trade->employee_id) }}">{{ $trade->creator_name}}</a>
                                </td>
                                <td>{{ number_format($trade->token_price) }}</td>
                                <td>{{ number_format($trade->token_quantity) }}</td>
                                <td>{{ number_format($trade->token_price * $trade->token_quantity) }}</td>
                                <td>{{ jdf_format($trade->created_at, 'Y/m/d') }}</td>
                                <td>
                                    @if($trade->user_id == auth()->id() || is_admin())
                                        @if(is_admin() && $trade->user_id != auth()->id())
                                            <form action="{{ url('trade/delete/') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="trade" value="{{ $trade->id }}">
                                                <button type="submit" class="btn btn-danger">
                                                    remove as admin
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ url('trade/delete/') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="trade" value="{{ $trade->id }}">
                                                <button type="submit" class="btn btn-danger">
                                                    حذف
                                                </button>
                                            </form>
                                        @endif
                                        {{--                                                                    @else--}}
                                        {{--                                                                        <a href="" data-certman_username="{{ $trade->certman_username }}" data-mobile="{{ $trade->mobile }}" data-id="{{ $trade->id }}" class="btn btn-light goForTrade">ثبت سفارش</a>--}}
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
                <h3>مستندات و تحلیل‌های معاملاتی و بنیادی</h3>

                <div class="col-md-4 col-12 mt-4">
                    <ol class="list-group list-group-numbered">
                        @foreach($data['symbol'] as $symbol)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <a href="{{ url('stock/symbol/'.$symbol->symbol_identifier) }}">
                                        <div class="fw-bold">{{ $symbol->symbol_identifier }}</div>
                                    </a>
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ number_format($symbol->token_price) }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function () {

            //
            // $(document).on('click', '.goForTrade', function (e) {
            //     e.preventDefault()
            //     var id = $(this).data('id')
            //     var certman_username = $(this).data('certman_username')
            //     var mobile = $(this).data('mobile')
            //     var text = `
            // <div style="text-align: right">
            //     <p>پس از ثبت سفارش، px طی یک روز کاری با شما و صاحب آگهی تماس می‌گیره و فرایند انتقال سهام رو براتون انجام می‌ده.</p>
            //     <p>اگه تصمیم دارید این معامله انجام بشه، دکمه «ثبت سفارش» رو بزنید.</p>
            // </div>`
            //
            //     Swal.fire({
            //         title: '',
            //         html: text,
            //         showCancelButton: true,
            //         confirmButtonText: 'ثبت سفارش',
            //         cancelButtonText: 'انصراف'
            //     }).then((result) => {
            //
            //         if (!result.isConfirmed)
            //             return
            //
            //         $.ajax({
            //             url: ROOT_URL + "/trade/goForTrade",
            //             type: 'POST',
            //             dataType: 'json',
            //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            //             data: {id: id},
            //             success: function (data, st, xhr) {
            //                 if (data.code == 1) {
            //                     var text = `<div class="text-center">
            //                 سفارش شما ثبت شد 🙂.
            //                 </div>`
            //                     Swal.fire({
            //                         title: '',
            //                         html: text,
            //                         showCancelButton: false,
            //                         confirmButtonText: 'بستن',
            //                     }).then((result) => {
            //
            //                     })
            //                 } else {
            //                     notification(data.message, '', 'error')
            //                 }
            //             },
            //             error: function (req, status, error) {
            //                 console.log('error')
            //             }
            //         }) // ajax
            //     });
            // })

            $(document).on('submit', '[name="form-new-trade"]', function (e) {
                e.preventDefault()
                var form = $(this).serialize()

                $.ajax({
                    url: ROOT_URL + "/trade/newTradeAd",
                    type: 'POST',
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: form,
                    success: function (resp, st, xhr) {
                        if (resp.code == 1) {
                            Swal.close()
                            window.location.reload()
                        } else {
                            notification(resp.message, '', 'error')
                        }
                    },
                    error: function (error) {
                        var count = (JSON.parse(error.responseText)).errors.count;
                        var price = (JSON.parse(error.responseText)).errors.price;
                        count ? notification(count, '', 'error') : '';
                        price ? notification(price, '', 'error') : '';
                    }
                })

            })

            $(document).on('input', '[name="form-new-trade"] [name="count"], [name="form-new-trade"] [name="price"]', function () {

                var count = text.toEnglish($(this).closest('form').find('[name="count"]').val())
                var price = text.toEnglish($(this).closest('form').find('[name="price"]').val())
                var sum = count * price
                if (isNaN(sum))
                    sum = 0

                sum = Number(sum).toLocaleString()
                $(this).closest('form').find('.sum').html(text.toPersian(`مجموعا ${sum} تومان`))
            })

            $(document).on('click', '.btn-open-trade', function (e) {
                e.preventDefault()
                var type = $(this).data('type')
                var min = $(this).data('min')
                var max = $(this).data('max')
                var caption = type == 1 ? 'ثبت آگهی خرید' : 'ثبت آگهی فروش'
                var html = `
                <form name="form-new-trade">
                    <input type="hidden" name="type" value="${type}" />
                    <div class="form-group text-start">
                        <label>تعداد مثقال</label>
                        <input type="text" name="count" class="form-control" value="">
                    </div>
                    <div class="form-group text-start">
                        <label>قیمت هر مثقال</label>
                        <input type="text" name="price" class="form-control" value="">
                        <small class="mt-2">بین ${min} تا ${max} تومان</small>
                    </div>

                    <div class="border sum mb-3 mt-3">
                        مجموعا: ۰ تومان
                    </div>
                    <button type="submit" class="btn btn-primary">${caption}</button>
                </form>
            `
                Swal.fire({
                    title: '',
                    html: html,
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonText: 'بریم برای امضای قرارداد',
                    cancelButtonText: 'بی خیال',
                }).then((result) => {

                    if (!result.isConfirmed)
                        return

                    return
                    $.ajax({
                        url: ROOT_URL + "/trade/goForTrade",
                        type: 'POST',
                        dataType: 'json',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {id: id},
                        success: function (data, st, xhr) {
                            if (data.code == 1) {
                                var text = `<div style="text-align: right">
                            در کمتر از یک روز کاری تیم px قرارداد انتقال سهام رو آماده می‌کنه و از شما برای امضا و انتقال وجه و سهام دعوت می‌کنه. مبارک باشه!
                            </div>`
                                Swal.fire({
                                    title: '',
                                    html: text,
                                    showCancelButton: false,
                                    confirmButtonText: 'بستن',
                                }).then((result) => {

                                })
                            } else {
                                notification(data.message, '', 'error')
                            }
                        },
                        error: function (req, status, error) {
                            console.log('error')
                        }
                    }) // ajax
                });

            })
        })
    </script>
@endpush

