@extends(isStockholderAndLeft() ? 'template.master-stockholder-left-user' : 'template.master-user')

@section('title', 'قراردادهای من در طرح مالکیت سهام اعضا')

@section('content')
    @include('template.messages')

    

    <div class="card ss02">

        <div class="card-content">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-2 mt-12">
                    
                    <div class="col mt-1">
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
                    </div>
                    
                    <div class="col mt-1">
                        <div class="stock-container">
                            <p class="stock-title">مثقال‌های آینده‌</p>
                            <p class="stock-number">{{ number_format($data['summary']['non-vested']['new']) }}</p>
                            <p class="subtext">ارزش امروز (تومان)</p>
                            <p class="extra">
                                <span>ارزش زمان قرارداد:</span>
                                <span>{{ number_format($data['summary']['non-vested']['old']) }} تومان</span>
                            </p>
                            <p class="extra">
                                <span>تعداد مثقال‌ها:</span>
                                <span>{{ number_format($data['summary']['non-vested']['count']) }}</span>
                            </p>
                        </div>
                    </div>
                    
                    
                    
                </div>
                
                
                <h3 class="mt-10">قراردادهای من در طرح مالکیت سهام اعضا</h3>

            </div>
            <div class="table-responsive">
                <table class="table mb-0 table-lg">
                    <thead>
                    <tr>
                        <th scope="col">تاریخ عقد قراردادِ طرح مالکیت سهام اعضا </th>
                        <th scope="col">عنوان</th>
                        <th scope="col">شرط واگذاری سهام</th>
                        <th scope="col">تعداد مثقال‌ها</th>
                        <th scope="col">مجموع ارزش زمان معامله</th>
                        <th scope="col">ارزش روز (تومان)</th>
                        <th scope="col">تاریخ واگذاری سهام</th>
                        <th scope="col">باطل شده</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['esops'] as $esop)
                        <tr>
                            <td>{{$esop->contracted_at ? jdf($esop->contracted_at) : null}}</td>
                            <td>{{$esop->title}}</td>
                            <td>{{$esop->vesting_rule}} {{ $esop->will_vest_at ? '(' . jdf($esop->will_vest_at) . ')' : null }}</td>
                            <td>{{number_format($esop->tokens_quantity) }}</td>
                            <td>{{number_format($esop->esop_value)}}</td>
                            <td>{{number_format($esop->tokens_quantity*$data['summary']['now_price']) }}</td>
                            <td>
                                @if($esop->vested_at && !$esop->expired_at)
                                    <span class='badge bg-success'>{{ $esop->vested_at ? jdf($esop->vested_at) : null }}</span>
                                @endif
                                @if(!$esop->espired_at && \Carbon\Carbon::parse($esop->will_vest_at)->gt(\Carbon\Carbon::now()))
                                    <span class="badge bg-secondary">{{ $esop->will_vest_at ? jdf($esop->will_vest_at) : null }}</span>
                                @endif
                            </td>
                            <td>{{ $esop->expired_at ? jdf($esop->expired_at) . '(' . $esop->expiration_description . ')' : null }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            {{ $data['esops']->onEachSide(0)->links() }}
        </div>
    </div>
@endsection
