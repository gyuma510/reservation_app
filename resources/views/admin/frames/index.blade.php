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
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">部屋名</th>
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
                            <td>{{ $frame->room->room_name }}</td>
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
@endsection
