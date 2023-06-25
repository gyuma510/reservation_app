@extends('layouts.parent')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.1/index.global.min.js'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <style>
        #color-legend {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            display: inline-block;
            margin-right: 5px;
        }

        .legend-color.black {
            background-color: black;
        }

        .legend-color.red {
            background-color: red;
        }

        .legend-color.yellow {
            background-color: yellow;
        }

        .legend-color.green {
            background-color: green;
        }

        .legend-label {
            font-size: 14px;
        }
    </style>

@section('title', '空室カレンダー')

@section('content')
<div class="container my-5">
    <div class="text-center mb-4">
        <h3>空室カレンダー</h3>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card-body">
                <p class="card-text">--プラン名--<br>{{ $plan->title }}</p>
                <p class="card-text">--プラン内容--<br>{{ $plan->description }}</p>
                <p class="card-text">--料金--<br>{{ $plan->min_price }}円 ~ {{ $plan->max_price }}円</p>
                <p class="card-text">--期間--<br>{{ date('Y年m月d日', strtotime($plan->start_date)) }} ~ {{ date('Y年m月d日', strtotime($plan->end_date)) }}</p>
            </div>
            <div class="form-group">
                <label for="room-type-selector">部屋タイプ：</label>
                <select id="room-type-selector" class="form-control" onchange="changeRoomType(this.value)">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6 text-right">
            <div id="carouselExampleIndicators{{$plan->id}}" class="carousel slide" data-ride="carousel">
                @if($plan->images->isEmpty())
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/nopicture.png') }}" class="d-block w-50" alt="No Picture">
                        </div>
                    </div>
                @else
                    <ol class="carousel-indicators">
                        @foreach($plan->images as $key => $image)
                            <li data-target="#carouselExampleIndicators{{$plan->id}}" data-slide-to="{{$key}}" class="{{$loop->first ? 'active' : ''}}"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($plan->images as $image)
                            <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                                <img src="{{ Storage::url($image->path) }}" class="d-block w-50">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators{{$plan->id}}" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators{{$plan->id}}" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            <div id='availability-calendar'></div>
        </div>
    </div>

    {{-- 色表示の基準表記 --}}
    <div id="color-legend">
        <div class="legend-item">
            <span class="legend-color black"></span>
            <span class="legend-label">予約不可</span>
        </div>
        <div class="legend-item">
            <span class="legend-color red"></span>
            <span class="legend-label">残り1室</span>
        </div>
        <div class="legend-item">
            <span class="legend-color yellow"></span>
            <span class="legend-label">残り3室以下</span>
        </div>
        <div class="legend-item">
            <span class="legend-color green"></span>
            <span class="legend-label">空きあり</span>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('reservations.show', $plan->id) }}" class="btn btn-secondary">{{ __('プラン詳細へ戻る') }}</a>
    </div>
</div>
    
<script>
    // 部屋タイプを切り替えた際の処理
    function changeRoomType(roomTypeId) {
        // 部屋タイプに応じて、空室カレンダーのデータを取得
        fetch(`/availability/calendar-data?plan_id={{ $plan->id }}&room_type_id=${roomTypeId}`)
            .then(response => response.json())
            .then(data => {
                // カレンダーを再描画
                const calendar = document.getElementById('availability-calendar');
                calendar.innerHTML = ''; // カレンダーをクリア
                const fullCalendar = new FullCalendar.Calendar(calendar, {
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay',
                    },
                    events: data,
                    eventColor: 'red',
                    eventTextColor: 'white',
                    eventClick: function(info) {
                        onCellClick(info.event);
                    }
                });
                fullCalendar.render();
            })
            .catch(error => {
                console.error(error);
                alert('カレンダーデータの取得に失敗しました。');
            });
    }

    // DOMContentLoaded イベントリスナー
    document.addEventListener('DOMContentLoaded', function() {
        // カレンダーと部屋タイプセレクタの要素を取得
        const availabilityCalendar = document.getElementById('availability-calendar');
        const roomTypeSelector = document.getElementById('room-type-selector');

        // カレンダーの設定
        const availabilityFullCalendar = new FullCalendar.Calendar(availabilityCalendar, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek',
            },
            initialView: 'dayGridMonth',
            events: '/availability/calendar-data?plan_id={{ $plan->id }}&room_type_id={{ $rooms[0]->id }}',
            eventColor: 'red',
            eventTextColor: 'white',
            eventClick: function(info) {
                onCellClick(info.event);
            }
        });
        // カレンダーを描画
        availabilityFullCalendar.render();

        // 部屋タイプを切り替えたときのイベントリスナーを設定
        roomTypeSelector.addEventListener('change', (event) => {
            const selectedRoomTypeId = event.target.value;
            changeRoomType(selectedRoomTypeId);
        });
    });

    // 予約フォームに遷移する関数
    function onCellClick(event) {
        // イベントが予約不可でない場合のみ、リダイレクトを行う
        if (!event.title.includes('×')) {
            const plan_id = {{ $plan->id }};
            const room_type_id = document.getElementById('room-type-selector').value;
            window.location.href = `/reservations/create/${plan_id}/${room_type_id}?date=${event.startStr}`;
        }
    }

</script>
@endsection
