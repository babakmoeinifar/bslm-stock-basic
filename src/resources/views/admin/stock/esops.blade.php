@extends('template.master-admin')

@section('title', 'قرارداد ها')

@section('content')
    @include('template.messages')

    <div class="card">
        <div class="card-header">

            <div class="row">
                <div class="col-9 col-md-6 col-sm-12">
                    <h3>قراردادها</h3>
                    <a href="{{url('admin/stock/esops/new/' . $data['userid'])}}">جدید</a>
                </div>
                <div class="col-3 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>انتخاب کاربر</label>
                        <select class="form-control form-select food-list" name="select-esops-user">
                            <option value="">همه</option>
                            @foreach($data['users'] as $user)
                                <option {{$user['id'] == $data['userid'] ? 'selected="selected"' : ''}} value="{{$user['id']}}">{{$user['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-content">
            <div class="table-responsive">
                <table class="table mb-0 table-lg">
                    <thead>
                    <tr>
                        <th scope="col">کاربر</th>
                        <th scope="col">عنوان</th>
                        <th scope="col">تعداد توکن</th>
                        <th scope="col">مجموع ارزش زمان معامله</th>
                        <th scope="col">شرط vest</th>
                        <th scope="col">will_vest_at</th>
                        <th scope="col">تاریخ عقد قرارداد</th>
                        <th scope="col">تاریخ vest</th>
                        <th scope="col">منقضی شده</th>
                        <th scope="col">علت انقضا</th>
                        <th scope="col">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['esops'] as $esop)
                        <tr>
                            @php
                                $userReceiver = \App\Models\User::find(\Bslm\Stock\Http\Models\StockShareholders::select()->where('id', $esop->shareholder_id)->first()->person_id);
                            @endphp
                            <td class="small">{{$userReceiver->name}}</td>
                            <td>{{$esop->title}}</td>
                            <td>{{number_format($esop->tokens_quantity)}}</td>
                            <td>{{number_format($esop->esop_value)}}</td>
                            <td>{{$esop->vesting_rule}}</td>
                            <td>{{ $esop->will_vest_at ? jdf($esop->will_vest_at) : null }}</td>
                            <td>{{ $esop->contracted_at ? jdf($esop->contracted_at) : null }}</td>
                            <td>{{ $esop->vested_at ? jdf($esop->vested_at) : null }}</td>
                            <td>{{ $esop->expired_at ? jdf($esop->expired_at) : null }}</td>
                            <td>{{$esop->expiration_description}}</td>
                            <td>
                                @if(!$esop->vested_at and !$esop->expired_at)
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            انتخاب عملیات
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a href="" data-id="{{$esop->id}}"
                                                   class="text-success btn-stock-vest dropdown-item">Vest</a>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                                        data-bs-target="#modal-{{$esop->id}}" dir="ltr">
                                                    EXPIRE!
                                                </button>
                                            </li>
                                            <li>
                                                <a href="{{ url('/admin/stock/esops/edit/' . $esop->id ) }}"
                                                   class="text-secondary dropdown-item">ویرایش</a>
                                            </li>

                                        </ul>
                                        <div class="modal fade" id="modal-{{$esop->id}}" tabindex="-1"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title"
                                                            id="exampleModalLabel">{{$esop->title}}</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ url('admin/stock/esops/expire/'.$esop->id) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('توجه! آیا از expire کردن این قرارداد اطمینان دارید؟');">
                                                            @csrf

                                                            <div class="form-group">
                                                                <label>تاریخ expire</label>
                                                                <input type="text" class="form-control date_start"
                                                                       name="" id="date_start" value="">
                                                                <input type="hidden" class="form-control expiredAt"
                                                                       name="expired_at" id="expiredAt">
                                                            </div>
                                                            <input type="hidden" name="esopTitle"
                                                                   value="{{ $esop->title }}">
                                                            <input type="hidden" name="shareholderId"
                                                                   value="{{ $esop->shareholder_id }}">

                                                            <div class="form-group">
                                                                <label>توضیحات</label>
                                                                <textarea class="form-control" rows="3"
                                                                          name="expiration_description">{{ old('expiration_description') }}</textarea>
                                                            </div>

                                                            <button type="submit" class="stock-expire btn btn-danger">
                                                                ثبت
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </td>
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

@push('css')
    <link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
@endpush

@push('js')
    <script src="{{ asset('js/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#date").pDatepicker({
                altField: '#date_alt',
                altFormat: 'X'
            });

            $('.food-list').selectpicker({
                liveSearch: true
            });
        });
    </script>
    <script>
        $('.btn-stock-vest').click(function () {
            return confirm('آیا از vest کردن این مورد نظر اطمینان دارید؟');
        });

        $(".date_start").pDatepicker({
            altField: '.expiredAt',
            altFormat: 'X',
            format: 'YYYY/MM/DD',
            observer: true
        })

        $(document).on('click', '.btn-stock-vest', function (e) {
            e.preventDefault()
            var _this = $(this)
            var id = $(this).data('id')
            $(this).addClass('disable')
            $.ajax({
                url: ROOT_URL + `/admin/stock/esops/vest/${id}`,
                type: 'POST',
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data, st, xhr) {
                    $(_this).removeClass('disable')
                    if (data.code == 1) {
                        window.location.reload();
                    } else {
                        notification(data.message, '', 'error')
                    }
                },
                error: function (req, status, error) {
                    $(_this).removeClass('disable')
                    window.location.reload();
                    console.log('error')
                }
            }) // ajax

        })
    </script>
@endpush