@extends('template.master-stockholder-left-user')

@section('title', 'داشبورد')

@section('content')
    @include('template.messages')

    @if(auth()->user()->unreadNotifications()->count() > 0)
        <div class="col-lg-6 col-md-12 row">
            <div class="card mb-3">
                <div class="pb-0 pt-3">
                    <h4 class="card-title d-flex justify-content-between">
                        <span>اعلان‌ها</span>
                        <a href="{{ url('/dashboard/notifications/reads') }}" class="btn btn-sm btn-light-secondary">خواندم</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($notifications as $notification)
                            <a
                                    @if($notification->data['type'] == 'sms')
                                        onclick="readNotification({{$notification}})"
                                    style="cursor: pointer"
                                    @else
                                        href="{{ '/'.$notification->data['link'] . '?readNotification=1' }}"
                                    @endif
                                    class="list-group-item d-flex justify-content-between align-items-center text-dark">

                                    <span>
                                        @if(is_null($notification->read_at))
                                            <span class="badge bg-secondary">
                                            <i class="bi bi-{{ notif_icon($notification->data['type']) }}"></i>
                                        </span>
                                        @else
                                            <span class="badge bg-light-secondary">
                                            <i class="bi bi-{{ notif_icon($notification->data['type']) }}"></i>
                                        </span>
                                        @endif
                                        {{ $notification->data['text']}}
                                    </span>

                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection