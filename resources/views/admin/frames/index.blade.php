@extends('layouts.app')
@section('title', '予約枠一覧')
@section('content')
    <div class="container my-5">
        <h3>予約枠一覧</h3>

        <div class="row mb-3">
            <div class="col-md-6">
                <a href="{{ route('frames.create') }}" class="btn btn-primary">予約枠作成</a>
            </div>
        </div>
        
        @foreach ($framesGroupedByRoomSortedByDate as $roomName => $frames)
            <div class="accordion" id="accordion-{{ $roomName }}">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-{{ $roomName }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#collapse-{{ $roomName }}" 
                                aria-expanded="false" aria-controls="collapse-{{ $roomName }}">
                            {{ $roomName }}
                        </button>
                    </h2>
                    <div id="collapse-{{ $roomName }}" class="accordion-collapse collapse" 
                         aria-labelledby="heading-{{ $roomName }}" data-bs-parent="#accordion-{{ $roomName }}">
                        <div class="accordion-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">日付</th>
                                        <th scope="col">予約枠数</th>
                                        <th scope="col">編集</th>
                                        <th scope="col">削除</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($frames as $frame)
                                        <tr>
                                            <th scope="row">{{ $frame->id }}</th>
                                            <td>{{ $frame->date }}</td>
                                            <td>{{ $frame->number }}</td>
                                            <td>
                                                <a href="{{ route('frames.edit', $frame->id) }}"
                                                    class="btn btn-primary btn-sm mr-2">編集</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('frames.destroy', $frame->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('本当に削除しますか？')">削除</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- アコーディオン処理 --}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
@endsection
