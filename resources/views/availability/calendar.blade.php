<!DOCTYPE html>
<html>

<head>
    <!-- 必要なライブラリの読み込み -->
    <meta charset='utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.1/index.global.min.js'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- スクリプト -->
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
                dateClick: function(info) {
                    onCellClick(info.dateStr);
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
        function onCellClick(date) {
            const plan_id = {{ $plan->id }};
            const room_type_id = document.getElementById('room-type-selector').value;
            window.location.href = `/reservations/create/${plan_id}/${room_type_id}?date=${date}`;
        }
    </script>
</head>

<body>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                @if ($plan->images->count() > 0)
                <div class="row">
                    @foreach ($plan->images as $image)
                        <div class="col-md-4 mb-3">
                            <img src="{{ asset($image->path) }}" alt="{{ $plan->title }}" class="w-100">
                        </div>
                    @endforeach
                </div>
            @else
                画像はありません
            @endif
            </div>
            <div class="col-md-6">
                <h1>{{ $plan->title }}</h1>
                <p>{{ $plan->description }}</p>
                <p>値段: {{ $plan->price }}</p>
                <div class="form-group">
                    <label for="room-type-selector">部屋タイプ：</label>
                    <select id="room-type-selector" class="form-control" onchange="changeRoomType(this.value)">
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <div id='availability-calendar'></div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('reservations.show', $plan->id) }}" class="btn btn-secondary">{{ __('プラン詳細へ戻る') }}</a>
        </div>
    </div>
</body>

</html>
