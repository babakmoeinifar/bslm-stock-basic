@csrf
<a href="{{ url('/admin/stock/trades-history') }}" class="btn btn-primary offset-11">برگشت</a>
<div class="row">

    <div class="form-group col-md-6 col-sm-12">
        <label>تاریخ شروع</label>
        <input type="text" class="form-control" name="" id="date_start" value="{{ old('from_date', $history->from_date) }}">
        <input type="hidden" class="form-control" name="date_start_alt" id="date_start_alt">
    </div>

    <div class="form-group col-md-6 col-sm-12">
        <label>تاریخ پایان</label>
        <input type="text" class="form-control" name="" id="date_end" value="{{ old('to_date', $history->to_date) }}">
        <input type="hidden" class="form-control" name="date_end_alt" id="date_end_alt">
    </div>

    <div class="form-group col-md-6 col-sm-12">
    <label>نماد</label>
    <select class="form-control" name="symbol_id">
        @foreach($symbols as $symbol)
            <option value="{{ $symbol->id }}" @if($symbol->id == $history->symbol_id) selected @endif>{{ $symbol->company_name }}</option>
        @endforeach
    </select>
    </div>

    <div class="form-group col-sm-12">
        <label>عنوان بازه</label>
        <input type="text" class="form-control" name="title" value="{{ old('title', $history->title) }}">
    </div>

    <div class="form-group col-md-6 col-sm-12">
        <label>حداقل قیمت مثقال</label>
        <input type="number" class="form-control" name="min_stock_transfer_price"
               value="{{ old('min_stock_transfer_price', $history->min_stock_transfer_price) }}">
    </div>
    <div class="form-group col-md-6 col-sm-12">
        <label>حداکثر قیمت مثقال</label>
        <input type="number" class="form-control" name="max_stock_transfer_price"
               value="{{ old('max_stock_transfer_price', $history->max_stock_transfer_price) }}">
    </div>

    <div class="form-group col-md-6 col-sm-12">
        <label>کران پایین قیمت مثقال</label>
        <input type="number" class="form-control" name="min_stock_price"
               value="{{ old('min_stock_price', $history->min_stock_price) }}">
    </div>
    <div class="form-group col-md-6 col-sm-12">
        <label>کران بالای قیمت مثقال</label>
        <input type="number" class="form-control" name="max_stock_price"
               value="{{ old('max_stock_price', $history->max_stock_price) }}">
    </div>

    <div class="form-group col-md-6 col-sm-12">
        <label>ارزش کل معاملات</label>
        <input type="number" class="form-control" name="trades_total_value"
               value="{{ old('trades_total_value', $history->trades_total_value) }}">
    </div>
    <div class="form-group col-md-6 col-sm-12">
        <label>میانگین وزنی قیمت مثقال</label>
        <input type="number" class="form-control" name="stock_weighted_average_price"
               value="{{ old('stock_weighted_average_price', $history->stock_weighted_average_price) }}">
    </div>

    <div class="form-group col-md-6 col-sm-12">
        <label>حجم عرضه</label>
        <input type="number" class="form-control" name="supply_volume"
               value="{{ old('supply_volume', $history->supply_volume) }}">
    </div>
    <div class="form-group col-md-6 col-sm-12">
        <label>حجم تقاضا</label>
        <input type="number" class="form-control" name="demand_volume"
               value="{{ old('demand_volume', $history->demand_volume) }}">
    </div>

    <div class="form-group col-md-6 col-sm-12">
        <label>حجم معاملات</label>
        <input type="number" class="form-control" name="traded_volume"
               value="{{ old('traded_volume', $history->traded_volume) }}">
    </div>
    <div class="form-group col-md-6 col-sm-12">
        <label>حجم بزرگ‌ترین معامله</label>
        <input type="number" class="form-control" name="highest_volume"
               value="{{ old('highest_volume', $history->highest_volume) }}">
    </div>

    <div class="form-group col-md-6 col-sm-12">
        <label>تعداد معامله‌کنندگان</label>
        <input type="number" class="form-control" name="number_of_traders"
               value="{{ old('number_of_traders', $history->number_of_traders) }}">
    </div>
    <div class="form-group col-md-6 col-sm-12">
        <label>تعداد معاملات</label>
        <input type="number" class="form-control" name="number_of_trades"
               value="{{ old('number_of_trades', $history->number_of_trades) }}">
    </div>

    <div class="form-group col-md-6 col-sm-12">
        <label>تعداد عرضه‌کنندگان</label>
        <input type="number" class="form-control" name="number_of_suppliers"
               value="{{ old('number_of_suppliers', $history->number_of_suppliers) }}">
    </div>
    <div class="form-group col-md-6 col-sm-12">
        <label>تعداد تقاضاکنندگان</label>
        <input type="number" class="form-control" name="number_of_demanders"
               value="{{ old('number_of_demanders', $history->number_of_demanders) }}">
    </div>

    <div class="form-check form-switch">
        <label class="form-check-label" for="active-switch">بازار صعودی</label>
        <input class="form-check-input" value="1" type="checkbox" id="active-switch"
               @if($history->bull_or_bear_market) checked @endif name="bull_or_bear_market">
    </div>

    <div class="form-group mt-3">
        <label>تحلیل فنی</label>
        <textarea name="technical_analysis" class="form-control"
                  rows="4">{{ old('technical_analysis', $history->technical_analysis) }}</textarea>
    </div>

    <div class="form-group mt-3">
        <label>تحلیل بنیادی</label>
        <textarea name="fundamental_analysis" class="form-control"
                  rows="4">{{ old('fundamental_analysis', $history->fundamental_analysis) }}</textarea>
    </div>

</div>


<button type="submit" class="btn btn-primary">{{ $buttonText ?? 'افزودن' }}</button>


@push('css')
    <link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('js/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
    <script>
        $("#date_start").pDatepicker({
            altField: '#date_start_alt',
            altFormat: 'X',
            format: 'YYYY/MM/DD',
            observer: true
        })

        $("#date_end").pDatepicker({
            altField: '#date_end_alt',
            altFormat: 'X',
            format: 'YYYY/MM/DD',
            observer: true
        })
    </script>
@endpush