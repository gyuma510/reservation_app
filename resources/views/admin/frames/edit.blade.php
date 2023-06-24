@extends('layouts.app')
@section('title', '予約枠編集')
@section('content')
    <div class="container my-5">
        <h1>予約枠編集</h1>
        <form method="POST" action="{{ route('frames.update', $frame->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="room_id">部屋名</label>
                <select id="room_id" name="room_id" class="form-control">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                    @endforeach
                </select>
                @error('room_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="date">日付</label>
                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date"
                    value="{{ $frame->date }}" required autocomplete="date" autofocus>
                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="number">予約枠の数</label>
                <input id="number" type="number" max="10"
                    class="form-control @error('number') is-invalid @enderror" name="number"
                    placeholder="例:10(半角数字で入力)"
                    value="{{ $frame->number }}" required autocomplete="number" autofocus>
                @error('number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">更新</button>
                <a href="{{ route('frames.index') }}" class="btn btn-secondary">{{ __('予約枠一覧へ戻る') }}</a>
            </div>
        </form>
    </div>
@endsection