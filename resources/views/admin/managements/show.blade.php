@extends('layouts.app')
@section('title', '宿泊予約詳細')
@section('content')
    <div class = "text-center"><br>
        <h3>宿泊予約詳細</h3><br>
    </div>
    <div class="table-responsive p-5">
        <table class = "table table-sm table-hover">
            <thead>
                <tr class = "text-center bg-light">
                    <th class="text-nowrap">名前</th>
                    <th class="text-nowrap">メールアドレス</th>
                    <th class="text-nowrap">電話番号</th>
                    <th class="text-nowrap">住所</th>
                    <th class="text-nowrap">メッセージ</th>
                    <th class="text-nowrap">宿泊プラン</th>
                    <th class="text-nowrap">宿泊開始日</th>
                    <th class="text-nowrap">宿泊終了日</th>
                    <th class="text-nowrap">予約日</th>
                    <th class="text-nowrap">管理者メモ</th>
                    <th class="text-nowrap">ステータス</th>
                </tr>
            </thead>
            <tbody>
                <tr class = "text-center table-cell">
                    <td class = "text-nowrap align-middle" style="width: 100px;">{{ $reservation->first_name }}{{ $reservation->last_name }}</td>
                    <td class = "text-nowrap align-middle" style="width: 150px;">{{ $reservation->email }}</td>
                    <td class = "text-nowrap align-middle" style="width: 150px;">{{ $reservation->phone }}</td>
                    <td class = "text-nowrap align-middle" style="width: 300px;">{{ $reservation->address }}</td>
                    <td class = "text-nowrap align-middle" style="width: 300px;">{{ $reservation->message }}</td>
                    <td class = "text-nowrap align-middle" style="width: 100px;">{{ $reservation->framePlan->plan->title ?? '' }}</td>
                    <td class = "text-nowrap align-middle" style="width: 100px;">{{ date('Y/m/d', strtotime($reservation->start_date)) }}</td>
                    <td class = "text-nowrap align-middle" style="width: 100px;">{{ date('Y/m/d', strtotime($reservation->end_date)) }}</td>
                    <td class = "text-nowrap align-middle" style="width: 100px;">{{ date('Y/m/d  H:m', strtotime($reservation->created_at)) }}</td>
                    <td class = "text-nowrap align-middle" style="width: 300px;">{{ $reservation->memo }}</td>
                    @if ($reservation->cancel == 1)
                        <td class="text-nowrap align-middle text-danger" style="width: 100px;">キャンセル済み</td>
                    @else
                        <td class="text-nowrap align-middle text-success" style="width: 100px;">予約済み</td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>
    <div class = "text-center">
        @if ($reservation->cancel != 1)
            <a href="{{ route('managements.cancel', $reservation->id) }}">
                <button type="button" class="btn btn-outline-danger" onclick="return confirm('この予約をキャンセルしますか？')">予約をキャンセルする</button>
            </a>
        @endif
        <a href = "{{ route('managements.index') }}"><button type = "button" class = "btn btn-outline-secondary">宿泊予約一覧へ戻る</button></a>
    </div>
@endsection
